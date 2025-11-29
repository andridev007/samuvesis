<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallet_balances', function (Blueprint $table) {
            $table->string('id_user', 36)->primary();
            $table->decimal('remaining_profit', 18, 2)->default(0);
            $table->decimal('remaining_bonus', 18, 2)->default(0);
            $table->decimal('referral_bonus_total', 18, 2)->default(0);
            $table->decimal('share_profit_bonus_total', 18, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_balances');
    }
};