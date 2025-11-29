<?php

namespace App\Http\Controllers\Admin;

use App\Enums\JoinStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JoinConfirmationController extends Controller
{
    public function index(Request $request)
    {
        $joins = DB::table('wt_join')
            ->where('status_join', JoinStatus::PENDING->value)
            ->orderByDesc('tgl_join')
            ->paginate(20);

        return view('admin.join.confirmation', compact('joins'));
    }

    public function approve(string $id)
    {
        DB::table('wt_join')
            ->where('id_join', $id)
            ->update(['status_join' => JoinStatus::ACTIVE->value]);

        // Optional: buat record confirmation
        DB::table('wt_join_confirm')->updateOrInsert(
            ['id_join' => $id],
            ['id_confirm' => substr(\Illuminate\Support\Str::uuid()->toString(),0,20), 'status_confirm' => 'confirmed']
        );

        return back()->with('success', 'Join approved.');
    }

    public function reject(string $id, Request $request)
    {
        DB::table('wt_join')
            ->where('id_join', $id)
            ->update(['status_join' => JoinStatus::REJECTED->value, 'note' => $request->input('note','')]);

        DB::table('wt_join_confirm')->updateOrInsert(
            ['id_join' => $id],
            ['id_confirm' => substr(\Illuminate\Support\Str::uuid()->toString(),0,20), 'status_confirm' => 'rejected']
        );

        return back()->with('success', 'Join rejected.');
    }
}