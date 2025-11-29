<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfitSettingSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [7,3,3,1,1,0.5,0.5,0.5,0.5];
        foreach ($levels as $i => $percent) {
            DB::table('wt_profit_setting')->updateOrInsert(
                ['level_profit_setting' => $i + 1],
                [
                    'id_profit_setting' => Str::uuid()->toString(),
                    'persen_profit_setting' => $percent,
                ]
            );
        }
    }
}