<?php

namespace App\Http\Controllers\Member;

use App\Enums\JoinStatus;
use App\Http\Controllers\Controller;
use App\Models\Join;
use App\Models\Program;
use App\Services\Wallet\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JoinController extends Controller
{
    public function __construct(private WalletService $wallet) {}

    public function index()
    {
        $programs = Program::query()->get();
        return view('member.join.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_prog' => 'required|string',
            'nominal_join' => 'required|numeric|min:0',
            'method' => 'required|in:manual,bonus,profit',
            'note' => 'nullable|string',
        ]);

        $program = Program::findOrFail($validated['id_prog']);
        $user = auth()->user();

        $nominal = (float) $validated['nominal_join'];
        $license = round($nominal * 0.10, 2);
        $kodeUnik = random_int(100, 999);
        $totalBayar = $nominal + $license + $kodeUnik;

        if (in_array($validated['method'], ['profit','bonus'])) {
            $walletType = $validated['method'] === 'profit' ? 'remaining_profit' : 'remaining_bonus';
            $this->wallet->debit($user->id_user, $walletType, $totalBayar, 'join', null, 'Compound join (includes 10% license & unique code)');
        }

        Join::create([
            'id_join' => Str::uuid()->toString(),
            'id_user' => $user->id_user,
            'id_prog' => $program->id_prog,
            'nominal_join' => $nominal,
            'insurance' => $license,
            'kode_unik' => $kodeUnik,
            'total_bayar' => $totalBayar,
            'tgl_join' => now(),
            'status_join' => JoinStatus::PENDING->value,
            'method' => $validated['method'],
            'note' => $validated['note'] ?? '',
            'wd_status' => 0,
        ]);

        return redirect()->route('member.join.history')
            ->with('success', 'Join request dibuat. ' .
                ($validated['method'] === 'manual'
                    ? 'Silakan transfer ke rekening SAMUVE.'
                    : 'Compound dari sumber ' . ($validated['method'] === 'profit' ? 'Remaining Profit' : 'Remaining Bonus') . ' berhasil.'));
    }

    public function history()
    {
        $joins = Join::query()
            ->where('id_user', auth()->user()->id_user)
            ->with('program')
            ->orderByDesc('tgl_join')
            ->paginate(15);

        return view('member.join.history', compact('joins'));
    }
}