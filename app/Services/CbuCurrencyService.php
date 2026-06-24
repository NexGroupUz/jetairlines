<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CbuCurrencyService
{
    public function usdRate(): float
    {
        return Cache::remember(
            'cbu_usd_rate',
            now()->addMinutes((int) config('currency.cache_ttl_minutes', 60)),
            function () {
                $url = rtrim((string) config('currency.cbu_base_url'), '/')
                    . '/ru/arkhiv-kursov-valyut/json/USD/';

                $response = Http::acceptJson()
                    ->timeout(10)
                    ->get($url)
                    ->throw()
                    ->json();

                if (!is_array($response) || empty($response[0]['Rate'])) {
                    throw new RuntimeException('Не удалось получить курс USD от ЦБ Узбекистана.');
                }

                return (float) str_replace(',', '.', $response[0]['Rate']);
            }
        );
    }

    public function usdToUzs(float|int $usd): int
    {
        return (int) round(((float) $usd) * $this->usdRate());
    }
}