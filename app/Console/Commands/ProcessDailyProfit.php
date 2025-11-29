<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Profit\ProfitProcessor;

class ProcessDailyProfit extends Command
{
    protected $signature = 'profit:process {percent : Persentase profit harian (contoh 1.5)} {--date= : Tanggal format Y-m-d (default: hari ini)}';
    protected $description = 'Memproses profit harian (Daily & Dream) termasuk distribusi jaringan dan auto-compound Dream';

    public function handle(ProfitProcessor $processor)
    {
        $percent = (float) $this->argument('percent');
        $dateStr = $this->option('date') ?? now()->format('Y-m-d');

        try {
            $date = new \DateTimeImmutable($dateStr);
        } catch (\Exception $e) {
            $this->error('Format tanggal tidak valid.');
            return self::FAILURE;
        }

        $processor->process($date, $percent);
        $this->info("Profit harian {$percent}% untuk tanggal {$dateStr} berhasil diproses.");
        return self::SUCCESS;
    }
}