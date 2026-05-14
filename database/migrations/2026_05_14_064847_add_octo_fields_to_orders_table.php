<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_provider')->default('octo')->after('status');

            $table->string('octo_payment_uuid')->nullable()->after('payment_provider');
            $table->string('octo_shop_transaction_id')->nullable()->after('octo_payment_uuid');
            $table->text('octo_pay_url')->nullable()->after('octo_shop_transaction_id');

            $table->json('octo_prepare_response')->nullable()->after('octo_pay_url');
            $table->json('octo_notify_payload')->nullable()->after('octo_prepare_response');

            $table->timestamp('paid_at')->nullable()->after('octo_notify_payload');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_provider',
                'octo_payment_uuid',
                'octo_shop_transaction_id',
                'octo_pay_url',
                'octo_prepare_response',
                'octo_notify_payload',
                'paid_at',
            ]);
        });
    }
};