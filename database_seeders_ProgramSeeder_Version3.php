<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('wt_join_group')->updateOrInsert(
            ['id_group' => 'daily'],
            ['nama_group' => 'Daily Salary Consortium']
        );
        DB::table('wt_join_group')->updateOrInsert(
            ['id_group' => 'dream'],
            ['nama_group' => 'Dream Consortium']
        );

        DB::table('wt_program')->updateOrInsert(
            ['id_prog' => 'daily-basic'],
            [
                'id_group' => 'daily',
                'nama_prog' => 'Daily Basic',
                'hrg_prog' => 0,
                'min_depo' => 100000,
                'est_balik' => 0,
                'est_terima' => 0
            ]
        );

        DB::table('wt_program')->updateOrInsert(
            ['id_prog' => 'dream-basic'],
            [
                'id_group' => 'dream',
                'nama_prog' => 'Dream Basic',
                'hrg_prog' => 0,
                'min_depo' => 1500000,
                'est_balik' => 0,
                'est_terima' => 0
            ]
        );
    }
}