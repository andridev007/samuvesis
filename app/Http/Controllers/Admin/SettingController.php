<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $referral = DB::table('wt_referral_setting')->orderBy('level_referral_setting')->get();
        $profit = DB::table('wt_profit_setting')->orderBy('level_profit_setting')->get();
        $programs = DB::table('wt_program')->orderBy('id_group')->get();
        $joinSetting = DB::table('wt_join_setting')->where('id_join_setting', 'default')->first();
        $withdrawSetting = DB::table('wt_withdraw_setting')->where('id_withdraw_setting', 'default')->first();

        return view('admin.settings.index', compact('referral', 'profit', 'programs', 'joinSetting', 'withdrawSetting'));
    }

    public function saveReferral(Request $request)
    {
        $levels = $request->input('levels', []);
        foreach ($levels as $level => $percent) {
            DB::table('wt_referral_setting')->updateOrInsert(
                ['level_referral_setting' => (int)$level],
                ['persen_referral_setting' => (float)$percent]
            );
        }
        return back()->with('success', 'Referral setting updated.');
    }

    public function saveProfit(Request $request)
    {
        $levels = $request->input('levels', []);
        foreach ($levels as $level => $percent) {
            DB::table('wt_profit_setting')->updateOrInsert(
                ['level_profit_setting' => (int)$level],
                ['persen_profit_setting' => (float)$percent]
            );
        }
        return back()->with('success', 'Profit setting updated.');
    }

    public function saveProgram(Request $request)
    {
        $data = $request->validate([
            'id_prog' => 'required|string',
            'id_group' => 'required|in:daily,dream',
            'nama_prog' => 'required|string',
            'hrg_prog' => 'nullable|numeric',
            'min_depo' => 'required|numeric|min:0',
            'est_balik' => 'nullable|integer',
            'est_terima' => 'nullable|integer',
        ]);

        DB::table('wt_program')->updateOrInsert(
            ['id_prog' => $data['id_prog']],
            $data
        );

        return back()->with('success', 'Program setting saved.');
    }

    public function saveJoin(Request $request)
    {
        $data = $request->validate(['min_join' => 'required|numeric|min:0']);
        DB::table('wt_join_setting')->updateOrInsert(
            ['id_join_setting' => 'default'],
            ['min_join' => (float)$data['min_join']]
        );
        return back()->with('success', 'Minimum join saved.');
    }

    public function saveWithdraw(Request $request)
    {
        $data = $request->validate([
            'min_withdraw' => 'required|numeric|min:0',
            'fee_withdraw' => 'required|numeric|min:0',
        ]);
        DB::table('wt_withdraw_setting')->updateOrInsert(
            ['id_withdraw_setting' => 'default'],
            [
                'min_withdraw' => (float)$data['min_withdraw'],
                'fee_withdraw' => (float)$data['fee_withdraw'],
            ]
        );
        return back()->with('success', 'Withdraw setting saved.');
    }
}