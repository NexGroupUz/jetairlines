<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CbuCurrencyService;
use App\Services\OctoService;
use App\Support\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Throwable;

class PaymentController extends Controller
{
    public function checkout(string $slug, CbuCurrencyService $currency): View
    {
        $product = Products::find($slug);

        abort_if(!$product, 404);

        $usdRate = $currency->usdRate();
        $amountUzs = $currency->usdToUzs((float) $product['price_usd']);

        return view('payment.checkout', [
            'product' => $product,
            'usdRate' => $usdRate,
            'amountUzs' => $amountUzs,
        ]);
    }

    public function create(Request $request, OctoService $octo, CbuCurrencyService $currency): RedirectResponse
    {
        $data = $request->validate([
            'product_slug' => ['required', 'string'],
            'customer_name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{7,14}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'accept_terms' => ['accepted'],
        ], [
            'customer_name.required' => 'Введите имя.',
            'customer_name.min' => 'Имя должно содержать минимум 2 символа.',
            'phone.required' => 'Введите номер телефона.',
            'phone.regex' => 'Введите номер телефона в международном формате. Например: +998901234567.',
            'email.email' => 'Введите корректный email.',
            'accept_terms.accepted' => 'Для перехода к оплате необходимо принять условия оферты и политики конфиденциальности.',
        ]);

        $product = Products::find($data['product_slug']);

        if (!$product) {
            return back()->withErrors([
                'product_slug' => 'Товар не найден.',
            ])->withInput();
        }

        $amountUsd = (float) $product['price_usd'];
        $usdRate = $currency->usdRate();
        $amountUzs = $currency->usdToUzs($amountUsd);

        $order = Order::create([
            'product_slug' => $product['slug'],
            'product_name' => $product['name'],

            // amount оставляем как сумму оплаты в UZS, чтобы OCTO работал без переделки
            'amount' => $amountUzs,
            'amount_usd' => $amountUsd,
            'usd_rate' => $usdRate,
            'amount_uzs' => $amountUzs,

            'customer_name' => $data['customer_name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'account' => 'INV-' . now()->format('YmdHis') . '-' . random_int(1000, 9999),
            'status' => 'created',
            'payment_provider' => 'octo',
        ]);

        try {
            $response = $octo->preparePayment($order);
            $payUrl = $octo->extractPaymentUrl($response);

            $order->update([
                'status' => 'payment_created',
                'octo_payment_uuid' => $octo->extractPaymentUuid($response),
                'octo_shop_transaction_id' => $octo->extractShopTransactionId($response),
                'octo_pay_url' => $payUrl,
                'octo_prepare_response' => $response,
            ]);

            return redirect()->away($payUrl);
        } catch (Throwable $e) {
            $order->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('payment.failed', $order)
                ->with('error', $e->getMessage());
        }
    }

    public function octoReturn(Order $order): RedirectResponse
    {
        /**
         * OCTO вернёт клиента сюда после оплаты.
         * Но финальный статус лучше доверять notify_url, а не return_url.
         */
        if ($order->status === 'paid') {
            return redirect()->route('payment.success', $order);
        }

        if ($order->status === 'failed') {
            return redirect()->route('payment.failed', $order);
        }

        return redirect()->route('payment.pending', $order);
    }

    public function octoNotify(Request $request, OctoService $octo): Response
    {
        $payload = $request->all();

        $shopTransactionId = $octo->getNotifyShopTransactionId($payload);
        $octoPaymentUuid = $octo->getNotifyPaymentUuid($payload);

        $order = null;

        if ($shopTransactionId) {
            $order = Order::where('account', $shopTransactionId)
                ->orWhere('octo_shop_transaction_id', $shopTransactionId)
                ->first();
        }

        if (!$order && $octoPaymentUuid) {
            $order = Order::where('octo_payment_uuid', $octoPaymentUuid)->first();
        }

        if (!$order) {
            \Log::channel('octo')->warning('OCTO notify received for unknown order', [
                'payload' => $payload,
            ]);

            return response('ORDER_NOT_FOUND', 404);
        }

        $isSuccess = $octo->isNotifySuccess($payload);

        $order->update([
            'status' => $isSuccess ? 'paid' : 'failed',
            'octo_notify_payload' => $payload,
            'paid_at' => $isSuccess ? now() : null,
        ]);

        return response('OK', 200);
    }

    public function pending(Order $order): View
    {
        return view('payment.pending', [
            'order' => $order,
        ]);
    }

    public function status(Order $order): RedirectResponse
    {
        return match ($order->status) {
            'paid' => redirect()->route('payment.success', $order),
            'failed' => redirect()->route('payment.failed', $order),
            default => redirect()->route('payment.pending', $order),
        };
    }

    public function success(Order $order): View
    {
        abort_if($order->status !== 'paid', 404);

        return view('payment.success', [
            'order' => $order,
        ]);
    }

    public function failed(Order $order): View
    {
        return view('payment.failed', [
            'order' => $order,
            'error' => session('error'),
        ]);
    }
}