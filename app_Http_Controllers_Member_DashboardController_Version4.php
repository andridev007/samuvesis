<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\WalletBalance;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id_user;

        $effectiveBalance = DB::table('wt_join')
            ->where('id_user', $userId)
            ->where('status_join', 'active')
            ->sum('nominal_join');

        $wallet = WalletBalance::find($userId);

        $remainingShareProfit = $wallet?->remaining_profit ?? 0;
        $remainingBonus = $wallet?->remaining_bonus ?? 0;
        $referralBonus = $wallet?->referral_bonus_total ?? 0;
        $shareProfitBonus = $wallet?->share_profit_bonus_total ?? 0;

        return view('member.dashboard', compact(
            'effectiveBalance',
            'remainingShareProfit',
            'referralBonus',
            'shareProfitBonus',
            'remainingBonus'
        ));
    }
}