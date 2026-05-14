<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_slug',
        'product_name',
        'amount',
        'customer_name',
        'phone',
        'email',
        'account',
        'status',

        'payment_provider',

        'octo_payment_uuid',
        'octo_shop_transaction_id',
        'octo_pay_url',
        'octo_prepare_response',
        'octo_notify_payload',
        'paid_at',

        // старые Atmos-поля можно оставить временно,
        // если они ещё есть в базе
        'atmos_transaction_id',
        'atmos_store_trans_id',
        'atmos_create_response',
        'atmos_pre_apply_response',
        'atmos_apply_response',
        'ofd_url',
        'is_test_card',
        'card_pan_mask',
    ];

    protected $casts = [
        'amount' => 'integer',
        'is_test_card' => 'boolean',

        'octo_prepare_response' => 'array',
        'octo_notify_payload' => 'array',
        'paid_at' => 'datetime',

        'atmos_create_response' => 'array',
        'atmos_pre_apply_response' => 'array',
        'atmos_apply_response' => 'array',
    ];
}