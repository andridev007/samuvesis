<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_user', 36);
            $table->enum('type', [
                'remaining_profit',
                'remaining_bonus',
                'referral_bonus',
                'share_profit_bonus',
                'compound_profit',
                'compound_bonus',
                'withdraw',
                'adjust',
                'license_fee'
            ]);
            $table->enum('direction', ['credit','debit']);
            $table->decimal('amount', 18, 2);
            $table->string('reference_type')->nullable();
            $table->string('reference_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['id_user','type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};