<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wt_join_effective_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_join', 36);
            $table->enum('type', ['compound','withdraw','adjust']);
            $table->decimal('amount', 18, 2);
            $table->date('movement_date');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['id_join','movement_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wt_join_effective_movements');
    }
};