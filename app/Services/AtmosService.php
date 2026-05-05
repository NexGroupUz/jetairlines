<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AtmosService
{
    private string $baseUrl;
    private string $consumerKey;
    private string $consumerSecret;
    private string $storeId;
    private string $terminalId;
    private string $lang;

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
        return Cache::remember('atmos_access_token', now()->addMinutes(35), function () {
            $token = $this->requestToken();

            if (!isset($token['access_token'])) {
                throw new RuntimeException('Atmos token response does not contain access_token.');
            }

            $ttl = (int) ($token['expires_in'] ?? 2525);

            Cache::put(
                'atmos_access_token',
                $token['access_token'],
                now()->addSeconds(max($ttl - 120, 60))
            );

            return $token['access_token'];
        });
    }

    public function refreshAccessToken(): string
    {
        Cache::forget('atmos_access_token');

        return $this->getAccessToken();
    }

    public function createTransaction(int $amount, string $account): array
    {
        return $this->authorizedPost('/merchant/pay/create', [
            'amount' => $amount,
            'account' => $account,
            'terminal_id' => $this->terminalId,
            'store_id' => $this->storeId,
            'lang' => $this->lang,
        ]);
    }

    public function preApply(string $cardNumber, string $expiry, int|string $transactionId): array
    {
        return $this->authorizedPost('/merchant/pay/pre-apply', [
            'card_number' => preg_replace('/\D+/', '', $cardNumber),
            'expiry' => preg_replace('/\D+/', '', $expiry),
            'store_id' => (int) $this->storeId,
            'transaction_id' => (int) $transactionId,
        ]);
    }

    public function apply(int|string $transactionId, string $otp): array
    {
        return $this->authorizedPost('/merchant/pay/apply', [
            'transaction_id' => (int) $transactionId,
            'otp' => $otp,
            'store_id' => (int) $this->storeId,
        ]);
    }

    private function requestToken(): array
    {
        $basic = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        try {
            return Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Basic ' . $basic,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->post($this->baseUrl . '/token', [
                    'grant_type' => 'client_credentials',
                ])
                ->throw()
                ->json();
        } catch (RequestException $e) {
            throw new RuntimeException(
                'Atmos token error: ' . $e->response?->body(),
                $e->getCode(),
                $e
            );
        }
    }

    private function authorizedPost(string $uri, array $payload): array
    {
        $token = $this->getAccessToken();

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->asJson()
                ->post($this->baseUrl . $uri, $payload);

            if ($response->status() === 401) {
                $token = $this->refreshAccessToken();

                $response = Http::withToken($token)
                    ->acceptJson()
                    ->asJson()
                    ->post($this->baseUrl . $uri, $payload);
            }

            return $response->throw()->json();
        } catch (RequestException $e) {
            throw new RuntimeException(
                'Atmos API error: ' . $e->response?->body(),
                $e->getCode(),
                $e
            );
        }
    }
}