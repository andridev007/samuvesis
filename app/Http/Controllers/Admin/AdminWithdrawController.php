<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawController extends Controller
{
    public function confirmation()
    {
        $reqs = DB::table('wt_withdraw')
            ->where('status_wd', WithdrawStatus::PENDING->value)
            ->orderByDesc('tgl_wd')
            ->paginate(20);

        return view('admin.withdraw.confirmation', compact('reqs'));
    }

    public function approve(string $id)
    {
        DB::table('wt_withdraw')->where('id_wd', $id)
            ->update(['status_wd' => WithdrawStatus::DONE->value]);

        DB::table('wt_withdraw_req')->updateOrInsert(
            ['id_wd' => $id],
            ['id_req' => substr(\Illuminate\Support\Str::uuid()->toString(),0,20), 'status_req' => 'done']
        );

        return back()->with('success', 'Withdraw approved.');
    }

    public function reject(string $id, Request $request)
    {
        DB::table('wt_withdraw')->where('id_wd', $id)
            ->update(['status_wd' => WithdrawStatus::REJECTED->value]);

        DB::table('wt_withdraw_req')->updateOrInsert(
            ['id_wd' => $id],
            ['id_req' => substr(\Illuminate\Support\Str::uuid()->toString(),0,20), 'status_req' => 'rejected', 'receipt' => $request->input('note','')]
        );

        return back()->with('success', 'Withdraw rejected.');
    }

    public function history()
    {
        $history = DB::table('wt_withdraw')->orderByDesc('tgl_wd')->paginate(20);
        return view('admin.withdraw.history', compact('history'));
    }
}