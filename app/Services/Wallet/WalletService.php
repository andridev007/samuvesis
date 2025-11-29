<?php

namespace App\Services\Wallet;

use App\Models\WalletBalance;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WalletService
{
    public function ensureBalanceRow(string $userId): WalletBalance
    {
        return WalletBalance::firstOrCreate(['id_user' => $userId]);
    }

    public function credit(string $userId, string $type, float $amount, ?string $refType = null, ?string $refId = null, ?string $note = null): void
    {
        DB::transaction(function () use ($userId, $type, $amount, $refType, $refId, $note) {
            $balance = $this->ensureBalanceRow($userId);
            $column = $this->mapTypeToColumn($type);

            if ($column) {
                $balance->{$column} += $amount;
                $balance->save();
            }

            WalletTransaction::create([
                'id_user' => $userId,
                'type' => $type,
                'direction' => 'credit',
                'amount' => $amount,
                'reference_type' => $refType,
                'reference_id' => $refId,
                'note' => $note,
            ]);
        });
    }

    public function debit(string $userId, string $type, float $amount, ?string $refType = null, ?string $refId = null, ?string $note = null): void
    {
        DB::transaction(function () use ($userId, $type, $amount, $refType, $refId, $note) {
            $balance = $this->ensureBalanceRow($userId);
            $column = $this->mapTypeToColumn($type);

            if ($column) {
                if ($balance->{$column} < $amount) {
                    throw new RuntimeException("Saldo {$type} tidak cukup.");
                }
                $balance->{$column} -= $amount;
                $balance->save();
            }

            WalletTransaction::create([
                'id_user' => $userId,
                'type' => $type,
                'direction' => 'debit',
                'amount' => $amount,
                'reference_type' => $refType,
                'reference_id' => $refId,
                'note' => $note,
            ]);
        });
    }

    private function mapTypeToColumn(string $type): ?string
    {
        return match ($type) {
            'remaining_profit' => 'remaining_profit',
            'remaining_bonus' => 'remaining_bonus',
            'referral_bonus' => 'referral_bonus_total',
            'share_profit_bonus' => 'share_profit_bonus_total',
            default => null,
        };
    }
}