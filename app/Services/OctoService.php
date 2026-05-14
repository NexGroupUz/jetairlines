<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class OctoService
{
    private string $baseUrl;
    private int|string $shopId;
    private string $secret;
    private bool $test;
    private string $language;
    private int $ttl;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('octo.base_url'), '/');
        $this->shopId = config('octo.shop_id');
        $this->secret = (string) config('octo.secret');
        $this->test = (bool) config('octo.test');
        $this->language = (string) config('octo.language', 'ru');
        $this->ttl = (int) config('octo.ttl', 15);
    }

    public function preparePayment(Order $order): array
    {
        $payload = $this->buildPreparePayload($order);

        return $this->post('/prepare_payment', $payload, [
            'operation' => 'prepare_payment',
            'order_id' => $order->id,
            'account' => $order->account,
        ]);
    }

    private function buildPreparePayload(Order $order): array
    {
        return [
            'octo_shop_id' => $this->shopId,
            'octo_secret' => $this->secret,

            'shop_transaction_id' => $order->account,

            'auto_capture' => true,
            'init_time' => now()->format('Y-m-d H:i:s'),
            'test' => $this->test,

            'user_data' => [
                'user_id' => (string) $order->customer_name,
                'phone' => $this->normalizePhoneForOcto($order->phone),
                'email' => $order->email ?: null,
            ],

            'total_sum' => $this->toOctoAmount($order->amount),
            'currency' => 'UZS',
            'description' => $this->makeDescription($order),

            /**
             * OCTO пишет basket в примере, но ты сказал, что он скорее всего не нужен.
             * Если OCTO потребует basket — раскомментируй блок ниже.
             */
            // 'basket' => [
            //     [
            //         'position_desc' => $order->product_name,
            //         'count' => 1,
            //         'price' => $this->toOctoAmount($order->amount),
            //         'spic' => '00000000000000000',
            //         'inn' => '30806790440016',
            //         'package_code' => '0000000',
            //         'nds' => 1,
            //     ],
            // ],

            'payment_methods' => [
                ['method' => 'bank_card'],
                ['method' => 'uzcard'],
                ['method' => 'humo'],
            ],

            'return_url' => route('payment.octo.return', $order, absolute: true),
            'notify_url' => route('payment.octo.notify', absolute: true),

            'language' => $this->language,
            'ttl' => $this->ttl,
        ];
    }

    private function post(string $uri, array $payload, array $context = []): array
    {
        $url = $this->baseUrl . $uri;
        $startedAt = microtime(true);

        Log::channel('octo')->info('OCTO request started', [
            'method' => 'POST',
            'url' => $url,
            'uri' => $uri,
            'context' => $context,
            'payload' => $this->maskSensitiveData($payload),
        ]);

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->post($url, $payload);

            $this->logResponse(
                title: 'OCTO response received',
                uri: $uri,
                response: $response,
                startedAt: $startedAt,
                context: $context
            );

            $body = $response->throw()->json();

            if (!is_array($body)) {
                throw new RuntimeException('OCTO response is not valid JSON.');
            }

            $this->assertOctoSuccess($body);

            return $body;
        } catch (RequestException $e) {
            Log::channel('octo')->error('OCTO HTTP request failed', [
                'uri' => $uri,
                'context' => $context,
                'duration_ms' => $this->durationMs($startedAt),
                'payload' => $this->maskSensitiveData($payload),
                'status' => $e->response?->status(),
                'response_body' => $e->response ? $this->safeJson($e->response) : null,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'OCTO HTTP error: ' . $e->response?->body(),
                $e->getCode(),
                $e
            );
        } catch (Throwable $e) {
            Log::channel('octo')->error('OCTO request failed', [
                'uri' => $uri,
                'context' => $context,
                'duration_ms' => $this->durationMs($startedAt),
                'payload' => $this->maskSensitiveData($payload),
                'error' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);

            throw $e;
        }
    }

    private function assertOctoSuccess(array $body): void
    {
        $error = (int) ($body['error'] ?? 999);

        if ($error === 0) {
            return;
        }

        $message = $body['errMessage']
            ?? $body['errorMessage']
            ?? $body['apiMessageForDevelopers']
            ?? 'Unknown OCTO error';

        throw new RuntimeException("OCTO error {$error}: {$message}");
    }

    public function extractPaymentUrl(array $response): string
    {
        $url = $response['data']['octo_pay_url']
            ?? $response['octo_pay_url']
            ?? null;

        if (!$url) {
            throw new RuntimeException('OCTO response does not contain octo_pay_url.');
        }

        return $url;
    }

    public function extractPaymentUuid(array $response): ?string
    {
        return $response['data']['octo_payment_UUID']
            ?? $response['octo_payment_UUID']
            ?? null;
    }

    public function extractShopTransactionId(array $response): ?string
    {
        return $response['data']['shop_transaction_id']
            ?? $response['shop_transaction_id']
            ?? null;
    }

    public function isNotifySuccess(array $payload): bool
    {
        $status = strtolower((string) (
            $payload['status']
            ?? $payload['data']['status']
            ?? ''
        ));

        if (in_array($status, ['paid', 'succeeded', 'success', 'completed', 'captured'], true)) {
            return true;
        }

        $error = $payload['error'] ?? $payload['data']['error'] ?? null;

        if ($error !== null && (int) $error === 0 && in_array($status, ['paid', 'success'], true)) {
            return true;
        }

        return false;
    }

    public function getNotifyShopTransactionId(array $payload): ?string
    {
        return $payload['shop_transaction_id']
            ?? $payload['data']['shop_transaction_id']
            ?? null;
    }

    public function getNotifyPaymentUuid(array $payload): ?string
    {
        return $payload['octo_payment_UUID']
            ?? $payload['octo_payment_uuid']
            ?? $payload['data']['octo_payment_UUID']
            ?? $payload['data']['octo_payment_uuid']
            ?? null;
    }

    private function toOctoAmount(int $amount): float
    {
        /**
         * У тебя цены в базе сейчас хранятся в сумах.
         * OCTO в примере принимает 1000.0 UZS, не тийины.
         */
        return (float) $amount;
    }

    private function normalizePhoneForOcto(string $phone): string
    {
        /**
         * В примере OCTO телефон без плюса: 998901234567.
         */
        return preg_replace('/\D+/', '', $phone);
    }

    private function makeDescription(Order $order): string
    {
        return mb_substr("Оплата заказа {$order->account}: {$order->product_name}", 0, 255);
    }

    private function logResponse(
        string $title,
        string $uri,
        Response $response,
        float $startedAt,
        array $context = []
    ): void {
        $body = $this->safeJson($response);

        $octoError = is_array($body) ? ($body['error'] ?? null) : null;
        $octoSuccess = $octoError !== null && (int) $octoError === 0;

        $level = $response->successful() && $octoSuccess ? 'info' : 'warning';

        Log::channel('octo')->{$level}($title, [
            'uri' => $uri,
            'context' => $context,
            'status' => $response->status(),
            'http_successful' => $response->successful(),
            'octo_successful' => $octoSuccess,
            'octo_error' => $octoError,
            'errMessage' => is_array($body) ? ($body['errMessage'] ?? null) : null,
            'duration_ms' => $this->durationMs($startedAt),
            'body' => $this->maskSensitiveData(is_array($body) ? $body : ['raw' => $body]),
        ]);
    }

    private function safeJson(Response $response): array|string|null
    {
        $json = $response->json();

        if (is_array($json)) {
            return $this->maskSensitiveData($json);
        }

        $body = $response->body();

        return $body !== '' ? $body : null;
    }

    private function maskSensitiveData(array $data): array
    {
        $sensitiveKeys = [
            'octo_secret',
            'secret',
            'password',
            'token',
            'access_token',
            'refresh_token',
            'card_number',
            'pan',
            'otp',
            'cvv',
            'cvc',
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->maskSensitiveData($value);
                continue;
            }

            if (in_array((string) $key, $sensitiveKeys, true)) {
                $data[$key] = $this->maskValue((string) $value);
            }
        }

        return $data;
    }

    private function maskValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (strlen($value) <= 8) {
            return '***';
        }

        return substr($value, 0, 4) . '***' . substr($value, -4);
    }

    private function durationMs(float $startedAt): int
    {
        return (int) round((microtime(true) - $startedAt) * 1000);
    }
}