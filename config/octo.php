<?php

return [
    'base_url' => env('OCTO_BASE_URL', 'https://secure.octo.uz'),

    'shop_id' => env('OCTO_SHOP_ID'),
    'secret' => env('OCTO_SECRET'),

    'test' => filter_var(env('OCTO_TEST', false), FILTER_VALIDATE_BOOLEAN),

    'language' => env('OCTO_LANGUAGE', 'ru'),
    'ttl' => (int) env('OCTO_TTL', 15),
];