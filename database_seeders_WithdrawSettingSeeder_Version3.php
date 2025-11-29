<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('wt_withdraw_setting')->updateOrInsert(
            ['id_withdraw_setting' => 'default'],
            [
                'min_withdraw' => 100000,
                'fee_withdraw' => 3.12
            ]
        );
    }
}