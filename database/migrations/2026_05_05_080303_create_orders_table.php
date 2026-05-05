<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('product_slug');
            $table->string('product_name');
            $table->unsignedBigInteger('amount');

            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();

            $table->string('account')->unique();

            $table->string('status')->default('created');
            // created, transaction_created, pre_applied, paid, failed

            $table->unsignedBigInteger('atmos_transaction_id')->nullable();
            $table->unsignedBigInteger('atmos_store_trans_id')->nullable();

            $table->json('atmos_create_response')->nullable();
            $table->json('atmos_pre_apply_response')->nullable();
            $table->json('atmos_apply_response')->nullable();

            $table->string('ofd_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};