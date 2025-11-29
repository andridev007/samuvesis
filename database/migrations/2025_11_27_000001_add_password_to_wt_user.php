<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('wt_user')) {
            Schema::table('wt_user', function (Blueprint $table) {
                if (!Schema::hasColumn('wt_user','password')) {
                    $table->string('password')->nullable()->after('wd_status');
                }
                if (!Schema::hasColumn('wt_user','remember_token')) {
                    $table->rememberToken();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('wt_user')) {
            Schema::table('wt_user', function (Blueprint $table) {
                $table->dropColumn(['password','remember_token']);
            });
        }
    }
};