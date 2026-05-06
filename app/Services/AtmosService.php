<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class AtmosService
{
    private string $baseUrl;
    private string $consumerKey;
    private string $consumerSecret;
    private string $storeId;
    private string $terminalId;
    private string $lang;

    const TEST_CARDS = [
        '9860090101014364',
        '9860090101893213',
        '9860090101842392',
        '9860090101469915',
        '5614688715378807',
        '8600492986215602',
    ];

    public function __construct()
    {
        $this->baseUrl = rtrim(config('atmos.base_url'), '/');
        $this->consumerKey = (string) config('atmos.consumer_key');
        $this->consumerSecret = (string) config('atmos.consumer_secret');
        $this->storeId = (string) config('atmos.store_id');
        $this->terminalId = (string) config('atmos.terminal_id');
        $this->lang = (string) config('atmos.lang', 'ru');
    }

    public function getAccessToken(): string
    {
        $cachedToken = Cache::get('atmos_access_token');

        if ($cachedToken) {
            return $cachedToken;
        }

        $token = $this->requestToken();

        if (!isset($token['access_token'])) {
            Log::channel('atmos')->error('Atmos token response without access_token', [
                'response' => $this->maskSensitiveData($token),
            ]);

            throw new RuntimeException('Atmos token response does not contain access_token.');
        }

        $ttl = (int) ($token['expires_in'] ?? 2525);

        Cache::put(
            'atmos_access_token',
            $token['access_token'],
            now()->addSeconds(max($ttl - 120, 60))
        );

        Log::channel('atmos')->info('Atmos token cached', [
            'expires_in' => $ttl,
            'cache_ttl_seconds' => max($ttl - 120, 60),
            'token_type' => $token['token_type'] ?? null,
            'scope' => $token['scope'] ?? null,
        ]);

        return $token['access_token'];
    }

    public function refreshAccessToken(): string
    {
        Log::channel('atmos')->warning('Atmos access token refresh started');

        Cache::forget('atmos_access_token');

        return $this->getAccessToken();
    }

    public function createTransaction(int $amount, string $account): array
    {
        return $this->authorizedPost('/merchant/pay/create', [
            'amount' => $this->toTiin($amount),
            'account' => $account,
            'terminal_id' => $this->terminalId,
            'store_id' => $this->storeId,
            'lang' => $this->lang,
        ], [
            'operation' => 'create_transaction',
            'amount_sum' => $amount,
            'amount_tiin' => $this->toTiin($amount),
            'account' => $account,
        ]);
    }

    public function preApply(string $cardNumber, string $expiry, int|string $transactionId): array
    {
        $normalizedCardNumber = $this->normalizeCardNumber($cardNumber);
        $normalizedExpiry = preg_replace('/\D+/', '', $expiry);

        $payload = [
            'card_number' => $normalizedCardNumber,
            'expiry' => $normalizedExpiry,
            'store_id' => (int) $this->storeId,
            'transaction_id' => (int) $transactionId,
        ];

        $context = [
            'operation' => 'pre_apply',
            'transaction_id' => (int) $transactionId,
            'is_test_card' => $this->isTestCard($normalizedCardNumber),
        ];

        return $this->authorizedPostWithBusinessRetry(
            uri: '/merchant/pay/pre-apply',
            payload: $payload,
            context: $context,
            maxAttempts: $this->isTestCard($normalizedCardNumber) ? 2 : 1
        );
    }

    public function apply(int|string $transactionId, string $otp, ?string $cardNumber = null): array
    {
        /**
         * ВАЖНО:
         * Чтобы apply тоже понимал, тестовая карта или нет,
         * лучше передавать cardNumber из контроллера.
         *
         * Если cardNumber не передали, будет 1 попытка.
         */
        $normalizedCardNumber = $cardNumber
            ? $this->normalizeCardNumber($cardNumber)
            : null;

        $payload = [
            'transaction_id' => (int) $transactionId,
            'otp' => $otp,
            'store_id' => (int) $this->storeId,
        ];

        $context = [
            'operation' => 'apply',
            'transaction_id' => (int) $transactionId,
            'is_test_card' => $normalizedCardNumber
                ? $this->isTestCard($normalizedCardNumber)
                : false,
        ];

        return $this->authorizedPostWithBusinessRetry(
            uri: '/merchant/pay/apply',
            payload: $payload,
            context: $context,
            maxAttempts: $normalizedCardNumber && $this->isTestCard($normalizedCardNumber) ? 2 : 1
        );
    }

    public function applyWithRetryMode(
        int|string $transactionId,
        string $otp,
        bool $isTestCard = false
    ): array {
        $payload = [
            'transaction_id' => (int) $transactionId,
            'otp' => $otp,
            'store_id' => (int) $this->storeId,
        ];

        $context = [
            'operation' => 'apply',
            'transaction_id' => (int) $transactionId,
            'is_test_card' => $isTestCard,
        ];

        return $this->authorizedPostWithBusinessRetry(
            uri: '/merchant/pay/apply',
            payload: $payload,
            context: $context,
            maxAttempts: $isTestCard ? 2 : 1
        );
    }

    private function requestToken(): array
    {
        $uri = '/token';
        $url = $this->baseUrl . $uri;

        $basic = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $payload = [
            'grant_type' => 'client_credentials',
        ];

        $startedAt = microtime(true);

        Log::channel('atmos')->info('Atmos token request started', [
            'method' => 'POST',
            'url' => $url,
            'payload' => $payload,
            'headers' => [
                'Authorization' => 'Basic ' . $this->maskToken($basic),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        try {
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Basic ' . $basic,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->post($url, $payload);

            $this->logResponse(
                title: 'Atmos token response received',
                uri: $uri,
                response: $response,
                startedAt: $startedAt
            );

            $body = $response->throw()->json();

            if (!is_array($body)) {
                throw new RuntimeException('Atmos token response is not valid JSON.');
            }

            return $body;
        } catch (RequestException $e) {
            $this->logRequestException(
                title: 'Atmos token request failed',
                exception: $e,
                uri: $uri,
                startedAt: $startedAt
            );

            throw new RuntimeException(
                'Atmos token error: ' . $e->response?->body(),
                $e->getCode(),
                $e
            );
        } catch (Throwable $e) {
            Log::channel('atmos')->error('Atmos token unexpected error', [
                'uri' => $uri,
                'duration_ms' => $this->durationMs($startedAt),
                'error' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);

            throw $e;
        }
    }

    /**
     * Метод с бизнес-повтором.
     *
     * Отличие от обычного retry:
     * Atmos может вернуть HTTP 200, но result.code != OK.
     * Поэтому проверяем не только HTTP-статус, но и тело ответа.
     */
    private function authorizedPostWithBusinessRetry(
        string $uri,
        array $payload,
        array $context = [],
        int $maxAttempts = 1
    ): array {
        $lastResponse = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                Log::channel('atmos')->info('Atmos business attempt started', [
                    'uri' => $uri,
                    'attempt' => $attempt,
                    'max_attempts' => $maxAttempts,
                    'context' => $context,
                    'payload' => $this->maskSensitiveData($payload),
                ]);

                $response = $this->authorizedPost($uri, $payload, array_merge($context, [
                    'attempt' => $attempt,
                    'max_attempts' => $maxAttempts,
                ]));

                $lastResponse = $response;

                if ($this->isAtmosBusinessOk($response)) {
                    Log::channel('atmos')->info('Atmos business attempt successful', [
                        'uri' => $uri,
                        'attempt' => $attempt,
                        'result_code' => $response['result']['code'] ?? null,
                        'context' => $context,
                    ]);

                    return $response;
                }

                Log::channel('atmos')->warning('Atmos business attempt failed with result code', [
                    'uri' => $uri,
                    'attempt' => $attempt,
                    'max_attempts' => $maxAttempts,
                    'result_code' => $response['result']['code'] ?? null,
                    'result_description' => $response['result']['description'] ?? null,
                    'response' => $this->maskSensitiveData($response),
                    'context' => $context,
                ]);

                if ($attempt < $maxAttempts) {
                    usleep(300_000);
                }
            } catch (Throwable $e) {
                Log::channel('atmos')->error('Atmos business attempt exception', [
                    'uri' => $uri,
                    'attempt' => $attempt,
                    'max_attempts' => $maxAttempts,
                    'context' => $context,
                    'payload' => $this->maskSensitiveData($payload),
                    'error' => $e->getMessage(),
                    'exception_class' => $e::class,
                ]);

                if ($attempt >= $maxAttempts) {
                    throw $e;
                }

                usleep(300_000);
            }
        }

        $code = $lastResponse['result']['code'] ?? 'UNKNOWN';
        $description = $lastResponse['result']['description'] ?? 'Unknown error';

        throw new RuntimeException("{$description}");
    }

    private function authorizedPost(string $uri, array $payload, array $context = []): array
    {
        $url = $this->baseUrl . $uri;
        $token = $this->getAccessToken();

        $startedAt = microtime(true);

        Log::channel('atmos')->info('Atmos API request started', [
            'method' => 'POST',
            'url' => $url,
            'uri' => $uri,
            'context' => $context,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->maskToken($token),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'payload' => $this->maskSensitiveData($payload),
        ]);

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->asJson()
                ->post($url, $payload);

            $this->logResponse(
                title: 'Atmos API response received',
                uri: $uri,
                response: $response,
                startedAt: $startedAt,
                context: $context
            );

            if ($response->status() === 401) {
                Log::channel('atmos')->warning('Atmos API returned 401, retrying with refreshed token', [
                    'uri' => $uri,
                    'context' => $context,
                    'response_body' => $this->safeJson($response),
                ]);

                $token = $this->refreshAccessToken();

                $retryStartedAt = microtime(true);

                Log::channel('atmos')->info('Atmos API retry request started', [
                    'method' => 'POST',
                    'url' => $url,
                    'uri' => $uri,
                    'context' => $context,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->maskToken($token),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'payload' => $this->maskSensitiveData($payload),
                ]);

                $response = Http::withToken($token)
                    ->acceptJson()
                    ->asJson()
                    ->post($url, $payload);

                $this->logResponse(
                    title: 'Atmos API retry response received',
                    uri: $uri,
                    response: $response,
                    startedAt: $retryStartedAt,
                    context: $context
                );
            }

            $body = $response->throw()->json();

            if (!is_array($body)) {
                throw new RuntimeException('Atmos API response is not valid JSON.');
            }

            return $body;
        } catch (RequestException $e) {
            $this->logRequestException(
                title: 'Atmos API request failed',
                exception: $e,
                uri: $uri,
                startedAt: $startedAt,
                context: $context,
                payload: $payload
            );

            throw new RuntimeException(
                'Atmos API error: ' . $e->response?->body(),
                $e->getCode(),
                $e
            );
        } catch (Throwable $e) {
            Log::channel('atmos')->error('Atmos API unexpected error', [
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

    private function isAtmosBusinessOk(array $response): bool
    {
        return isset($response['result']['code'])
            && strtoupper((string) $response['result']['code']) === 'OK';
    }

    private function logResponse(
        string $title,
        string $uri,
        Response $response,
        float $startedAt,
        array $context = []
    ): void {
        $body = $this->safeJson($response);

        $isBusinessOk = is_array($body) && $this->isAtmosBusinessOk($body);

        /**
         * HTTP 200, но result.code != OK — это warning.
         */
        $level = $response->successful() && $isBusinessOk ? 'info' : 'warning';

        Log::channel('atmos')->{$level}($title, [
            'uri' => $uri,
            'context' => $context,
            'status' => $response->status(),
            'http_successful' => $response->successful(),
            'business_successful' => $isBusinessOk,
            'result_code' => is_array($body) ? ($body['result']['code'] ?? null) : null,
            'result_description' => is_array($body) ? ($body['result']['description'] ?? null) : null,
            'duration_ms' => $this->durationMs($startedAt),
            'headers' => $this->maskSensitiveData($response->headers()),
            'body' => $body,
        ]);
    }

    private function logRequestException(
        string $title,
        RequestException $exception,
        string $uri,
        float $startedAt,
        array $context = [],
        array $payload = []
    ): void {
        Log::channel('atmos')->error($title, [
            'uri' => $uri,
            'context' => $context,
            'duration_ms' => $this->durationMs($startedAt),
            'payload' => $this->maskSensitiveData($payload),
            'status' => $exception->response?->status(),
            'response_headers' => $exception->response
                ? $this->maskSensitiveData($exception->response->headers())
                : null,
            'response_body' => $exception->response
                ? $this->safeJson($exception->response)
                : null,
            'error' => $exception->getMessage(),
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
            'authorization',
            'Authorization',
            'access_token',
            'refresh_token',
            'token',
            'consumer_secret',
            'consumerSecret',
            'card_number',
            'cardNumber',
            'pan',
            'PAN',
            'otp',
            'cvv',
            'cvc',
            'password',
            'secret',
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->maskSensitiveData($value);
                continue;
            }

            if (in_array((string) $key, $sensitiveKeys, true)) {
                if (in_array((string) $key, ['card_number', 'cardNumber', 'pan', 'PAN'], true)) {
                    $data[$key] = $this->maskCardNumber((string) $value);
                } else {
                    $data[$key] = $this->maskValue((string) $value);
                }

                continue;
            }

            if (is_string($value) && $this->looksLikeCardNumber($value)) {
                $data[$key] = $this->maskCardNumber($value);
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

    private function maskToken(string $token): string
    {
        return $this->maskValue($token);
    }

    private function maskCardNumber(string $cardNumber): string
    {
        $digits = preg_replace('/\D+/', '', $cardNumber);

        if (strlen($digits) < 10) {
            return '***';
        }

        return substr($digits, 0, 6)
            . str_repeat('*', max(strlen($digits) - 10, 0))
            . substr($digits, -4);
    }

    private function looksLikeCardNumber(string $value): bool
    {
        $digits = preg_replace('/\D+/', '', $value);

        return strlen($digits) >= 13 && strlen($digits) <= 19;
    }

    private function normalizeCardNumber(string $cardNumber): string
    {
        return preg_replace('/\D+/', '', $cardNumber);
    }

    private function isTestCard(string $cardNumber): bool
    {
        return in_array($this->normalizeCardNumber($cardNumber), self::TEST_CARDS, true);
    }

    private function durationMs(float $startedAt): int
    {
        return (int) round((microtime(true) - $startedAt) * 1000);
    }

    private function toTiin(int $amount): int
    {
        return $amount * 100;
    }
}