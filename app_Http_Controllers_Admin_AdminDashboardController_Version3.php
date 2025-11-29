<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = DB::table('wt_user')->count();
        $verifiedUsers = DB::table('wt_user')->where('acc_status', 'verified')->count();

        $effectiveBalanceSum = DB::table('wt_join')
            ->where('status_join', 'active')->sum('nominal_join');

        $remainingShareProfit = DB::table('wallet_balances')->sum('remaining_profit');
        $referralBonusSum = DB::table('wallet_balances')->sum('referral_bonus_total');
        $shareProfitBonusSum = DB::table('wallet_balances')->sum('share_profit_bonus_total');
        $usersRemainingProfit = DB::table('wallet_balances')->sum('remaining_profit');
        $withdrawSum = DB::table('wt_withdraw')->sum('nominal_wd');

        $dreamStats = [
            'total_balance' => DB::table('wt_join')
                ->where('status_join', 'active')
                ->whereExists(function ($q) {
                    $q->select(DB::raw(1))
                      ->from('wt_program')
                      ->whereColumn('wt_program.id_prog', 'wt_join.id_prog')
                      ->where('wt_program.id_group', 'dream');
                })->sum('nominal_join'),
            'share_profit' => DB::table('wt_profit_get')->sum('nominal_profit_get'),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'effectiveBalanceSum',
            'remainingShareProfit',
            'referralBonusSum',
            'shareProfitBonusSum',
            'usersRemainingProfit',
            'withdrawSum',
            'dreamStats'
        ));
    }
}