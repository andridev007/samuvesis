<?php

namespace App\Services\Profit;

use App\Models\Join;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfitProcessor
{
    public function process(\DateTimeInterface $date, float $percentDay): void
    {
        DB::transaction(function () use ($date, $percentDay) {
            $profitDayId = $this->recordProfitDay($date, $percentDay);

            $joins = Join::query()
                ->with('program', 'user')
                ->where('status_join', 'active')
                ->get();

            foreach ($joins as $join) {
                $effectiveBalance = $this->getEffectiveBalance($join);
                if ($effectiveBalance <= 0) continue;

                $user60 = $effectiveBalance * ($percentDay / 100) * 0.60;
                $admin40 = $effectiveBalance * ($percentDay / 100) * 0.40;

                $profitGetId = $this->recordProfitGet($profitDayId, $join->id_join, $percentDay, $user60, $date);
                $this->distributeProfitShare($join, $profitGetId, $admin40);

                if ($join->program && $join->program->id_group === 'dream') {
                    $this->dreamAutoCompoundWithLicense($join, $user60, $date);
                } else {
                    $this->creditRemainingProfit($join->id_user, $user60, $profitGetId);
                }
            }
        });
    }

    protected function recordProfitDay(\DateTimeInterface $date, float $percentDay): string
    {
        $id = Str::uuid()->toString();
        DB::table('wt_profit_perday')->insert([
            'id_profit_day' => $id,
            'persen_day' => $percentDay,
            'profit_day' => 0,
            'tgl_profit_day' => $date->format('Y-m-d'),
        ]);
        return $id;
    }

    protected function recordProfitGet(string $profitDayId, string $joinId, float $percentDay, float $nominal, \DateTimeInterface $date): string
    {
        $id = Str::uuid()->toString();
        DB::table('wt_profit_get')->insert([
            'id_profit_get' => $id,
            'id_profit_day' => $profitDayId,
            'id_join' => $joinId,
            'persen_profit_get' => $percentDay,
            'nominal_profit_get' => $nominal,
            'tgl_profit_get' => $date->format('Y-m-d'),
        ]);
        return $id;
    }

    protected function distributeProfitShare(Join $join, string $profitGetId, float $admin40): void
    {
        $percents = DB::table('wt_profit_setting')
            ->orderBy('level_profit_setting')
            ->pluck('persen_profit_setting')
            ->values()
            ->all();

        $uplines = $this->getUplines($join->user, 9);

        foreach ($uplines as $idx => $uplineUserId) {
            $percent = $percents[$idx] ?? 0;
            $amount = $admin40 * ($percent / 100);
            if ($amount <= 0) continue;

            DB::table('wt_profit_share')->insert([
                'id_profit' => Str::uuid()->toString(),
                'id_join' => $join->id_join,
                'id_profit_get' => $profitGetId,
                'dari_user_profit' => $join->id_user,
                'untuk_user_profit' => $uplineUserId,
                'level_profit' => (string) ($idx + 1),
                'persen_profit' => $percent,
                'nominal_profit' => $amount,
            ]);

            $this->creditRemainingBonus($uplineUserId, $amount, $profitGetId);
            $this->creditShareProfitBonusAgg($uplineUserId, $amount);
        }
    }

    protected function dreamAutoCompoundWithLicense(Join $join, float $user60, \DateTimeInterface $date): void
    {
        $license = round($user60 * 0.10, 2);
        $netCompound = max(0, $user60 - $license);

        $this->creditRemainingProfit($join->id_user, $user60, null, 'Dream daily profit');
        $this->debitCompound($join->id_user, 'compound_profit', $netCompound, 'dream_auto', $join->id_join, 'Dream auto-compound');
        $this->debitCompound($join->id_user, 'license_fee', $license, 'dream_license', $join->id_join, 'Dream auto-compound license 10%');

        DB::table('wt_join_effective_movements')->insert([
            'id' => Str::uuid()->toString(),
            'id_join' => $join->id_join,
            'type' => 'compound',
            'amount' => $netCompound,
            'movement_date' => $date->format('Y-m-d'),
            'note' => 'Dream auto-compound (net after 10% license)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function creditRemainingProfit(string $userId, float $amount, ?string $refId = null, string $note = 'Daily remaining share profit'): void
    {
        $this->insertWalletTransaction($userId, 'remaining_profit', 'credit', $amount, 'profit_get', $refId, $note);
        $this->upsertBalanceIncrement($userId, 'remaining_profit', $amount);
    }

    protected function creditRemainingBonus(string $userId, float $amount, ?string $refId = null): void
    {
        $this->insertWalletTransaction($userId, 'remaining_bonus', 'credit', $amount, 'profit_share', $refId, 'Network remaining bonus (profit share)');
        $this->upsertBalanceIncrement($userId, 'remaining_bonus', $amount);
    }

    protected function creditShareProfitBonusAgg(string $userId, float $amount): void
    {
        DB::table('wallet_balances')
            ->updateOrInsert(['id_user' => $userId], [
                'share_profit_bonus_total' => DB::raw("COALESCE(share_profit_bonus_total,0)+{$amount}"),
                'updated_at' => now(),
                'created_at' => now()
            ]);
    }

    protected function debitCompound(string $userId, string $type, float $amount, ?string $refType = null, ?string $refId = null, ?string $note = null): void
    {
        $this->insertWalletTransaction($userId, $type, 'debit', $amount, $refType, $refId, $note);

        if ($type === 'compound_profit') {
            $this->upsertBalanceDecrement($userId, 'remaining_profit', $amount);
        }
        if ($type === 'compound_bonus') {
            $this->upsertBalanceDecrement($userId, 'remaining_bonus', $amount);
        }
    }

    protected function insertWalletTransaction(string $userId, string $type, string $direction, float $amount, ?string $refType, ?string $refId, ?string $note): void
    {
        DB::table('wallet_transactions')->insert([
            'id' => Str::uuid()->toString(),
            'id_user' => $userId,
            'type' => $type,
            'direction' => $direction,
            'amount' => $amount,
            'reference_type' => $refType,
            'reference_id' => $refId,
            'note' => $note,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function upsertBalanceIncrement(string $userId, string $column, float $amount): void
    {
        DB::table('wallet_balances')
            ->updateOrInsert(['id_user' => $userId], [
                $column => DB::raw("COALESCE($column,0)+{$amount}"),
                'updated_at' => now(),
                'created_at' => now()
            ]);
    }

    protected function upsertBalanceDecrement(string $userId, string $column, float $amount): void
    {
        DB::table('wallet_balances')
            ->updateOrInsert(['id_user' => $userId], [
                $column => DB::raw("GREATEST(COALESCE($column,0)-{$amount},0)"),
                'updated_at' => now(),
                'created_at' => now()
            ]);
    }

    protected function getUplines($user, int $levels): array
    {
        $result = [];
        $current = $user;
        for ($i = 0; $i < $levels; $i++) {
            if (!$current || !$current->id_user_referral) break;
            $result[] = $current->id_user_referral;
            $current = \App\Models\User::query()->find($current->id_user_referral);
        }
        return $result;
    }

    protected function getEffectiveBalance(Join $join): float
    {
        $base = (float) $join->nominal_join;

        $compoundSum = (float) DB::table('wt_join_effective_movements')
            ->where('id_join', $join->id_join)
            ->where('type', 'compound')
            ->sum('amount');

        $wdSum = (float) DB::table('wt_withdraw_join')
            ->where('id_join', $join->id_join)
            ->sum('nominal_wd');

        return max(0, $base + $compoundSum - $wdSum);
    }
}