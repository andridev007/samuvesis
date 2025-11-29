<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JoinSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('wt_join_setting')->updateOrInsert(
            ['id_join_setting' => 'default'],
            ['min_join' => 100000]
        );
    }
}