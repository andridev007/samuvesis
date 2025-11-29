<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferralSettingSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [7,3,3,1,1,0.5,0.5,0.5,0.5];
        foreach ($levels as $i => $percent) {
            DB::table('wt_referral_setting')->updateOrInsert(
                ['level_referral_setting' => $i + 1],
                [
                    'id_referral_setting' => Str::uuid()->toString(),
                    'persen_referral_setting' => $percent,
                ]
            );
        }
    }
}