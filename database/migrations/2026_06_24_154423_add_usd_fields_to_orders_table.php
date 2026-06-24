<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('amount_usd', 12, 2)->nullable()->after('amount');
            $table->decimal('usd_rate', 12, 2)->nullable()->after('amount_usd');
            $table->unsignedBigInteger('amount_uzs')->nullable()->after('usd_rate');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'amount_usd',
                'usd_rate',
                'amount_uzs',
            ]);
        });
    }
};