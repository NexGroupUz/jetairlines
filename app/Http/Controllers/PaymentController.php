<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\AtmosService;
use App\Support\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class PaymentController extends Controller
{
    public function checkout(string $slug): View
    {
        $product = Products::find($slug);

        abort_if(!$product, 404);

        return view('payment.checkout', [
            'product' => $product,
        ]);
    }

    public function create(Request $request, AtmosService $atmos): RedirectResponse
    {
        $data = $request->validate([
            'product_slug' => [
                'required',
                'string',
            ],
            'customer_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+[1-9]\d{7,14}$/',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
        ], [
            'customer_name.required' => 'Введите имя.',
            'customer_name.min' => 'Имя должно содержать минимум 2 символа.',
            'phone.required' => 'Введите номер телефона.',
            'phone.regex' => 'Введите номер телефона в международном формате. Например: +998901234567.',
            'email.email' => 'Введите корректный email.',
        ]);

        $product = Products::find($data['product_slug']);

        if (!$product) {
            return back()->withErrors([
                'product_slug' => 'Товар не найден.',
            ])->withInput();
        }

        $order = Order::create([
            'product_slug' => $product['slug'],
            'product_name' => $product['name'],
            'amount' => $product['price'],
            'customer_name' => $data['customer_name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'account' => 'INV-' . now()->format('YmdHis') . '-' . random_int(1000, 9999),
            'status' => 'created',
        ]);

        try {
            $response = $atmos->createTransaction(
                amount: $order->amount,
                account: $order->account
            );

            $order->update([
                'status' => 'transaction_created',
                'atmos_transaction_id' => $response['transaction_id'] ?? null,
                'atmos_store_trans_id' => $response['store_transaction']['trans_id'] ?? null,
                'atmos_create_response' => $response,
            ]);
        } catch (Throwable $e) {
            $order->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('payment.failed', $order)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('payment.card', $order);
    }

    public function card(Order $order): View
    {
        abort_if($order->status !== 'transaction_created', 404);

        return view('payment.card', [
            'order' => $order,
        ]);
    }

    public function preApply(Request $request, Order $order, AtmosService $atmos): RedirectResponse
    {
        $data = $request->validate([
            'card_number' => [
                'required',
                'string',
                'regex:/^\d{16}$/',
            ],
            'expiry' => [
                'required',
                'string',
                'regex:/^\d{4}$/',
            ],
        ], [
            'card_number.required' => 'Введите номер карты.',
            'card_number.regex' => 'Номер карты должен содержать ровно 16 цифр.',
            'expiry.required' => 'Введите срок действия карты.',
            'expiry.regex' => 'Срок действия карты должен быть в формате YYMM.',
        ]);

        $expiryYear = substr($data['expiry'], 0, 2);
        $expiryMonth = substr($data['expiry'], 2, 2);

        if ((int) $expiryMonth < 1 || (int) $expiryMonth > 12) {
            return back()->withErrors([
                'expiry' => 'Месяц срока действия карты должен быть от 01 до 12.',
            ])->withInput();
        }

        if (!$order->atmos_transaction_id) {
            return back()->withErrors([
                'payment' => 'ID транзакции Atmos не найден.',
            ]);
        }

        try {
            $response = $atmos->preApply(
                cardNumber: $data['card_number'],
                expiry: $data['expiry'],
                transactionId: $order->atmos_transaction_id
            );

            $order->update([
                'status' => 'pre_applied',
                'is_test_card' => $this->isAtmosTestCard($data['card_number']),
                'card_pan_mask' => $this->maskCardNumber($data['card_number']),
                'atmos_pre_apply_response' => $response,
            ]);
        } catch (Throwable $e) {
            $order->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('payment.failed', $order)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('payment.otp', $order);
    }

    public function otp(Order $order): View
    {
        abort_if($order->status !== 'pre_applied', 404);

        return view('payment.otp', [
            'order' => $order,
        ]);
    }

    public function apply(Request $request, Order $order, AtmosService $atmos): RedirectResponse
    {
        $data = $request->validate([
            'otp' => ['required', 'string', 'max:10'],
        ]);

        if (!$order->atmos_transaction_id) {
            return back()->withErrors([
                'payment' => 'ID транзакции Atmos не найден.',
            ]);
        }

        try {
            $response = $atmos->applyWithRetryMode(
                transactionId: $order->atmos_transaction_id,
                otp: $data['otp'],
                isTestCard: $order->is_test_card
            );

            $order->update([
                'status' => 'paid',
                'atmos_apply_response' => $response,
                'ofd_url' => $response['ofd_url'] ?? null,
            ]);
        } catch (Throwable $e) {
            $order->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('payment.failed', $order)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('payment.success', $order);
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

    private function normalizeCardNumber(string $cardNumber): string
    {
        return preg_replace('/\D+/', '', $cardNumber);
    }

    private function maskCardNumber(string $cardNumber): string
    {
        $digits = $this->normalizeCardNumber($cardNumber);

        if (strlen($digits) < 10) {
            return '***';
        }

        return substr($digits, 0, 6)
            . str_repeat('*', max(strlen($digits) - 10, 0))
            . substr($digits, -4);
    }

    private function isAtmosTestCard(string $cardNumber): bool
    {
        return in_array($this->normalizeCardNumber($cardNumber), AtmosService::TEST_CARDS, true);
    }
}