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
        'atmos_transaction_id',
        'atmos_store_trans_id',
        'atmos_create_response',
        'atmos_pre_apply_response',
        'atmos_apply_response',
        'ofd_url',
    ];

    protected $casts = [
        'amount' => 'integer',
        'atmos_create_response' => 'array',
        'atmos_pre_apply_response' => 'array',
        'atmos_apply_response' => 'array',
    ];
}