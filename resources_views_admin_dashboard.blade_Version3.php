@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Admin Dashboard</h1>
<div class="grid md:grid-cols-4 gap-4">
    <div class="card"><div class="text-sm text-brand-300">Total User</div><div class="text-2xl font-bold">{{ $totalUsers }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Verified Users</div><div class="text-2xl font-bold">{{ $verifiedUsers }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Effective Balance</div><div class="text-2xl font-bold">{{ number_format($effectiveBalanceSum,2) }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Remaining Share Profit</div><div class="text-2xl font-bold">{{ number_format($remainingShareProfit,2) }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Referral Bonus</div><div class="text-2xl font-bold">{{ number_format($referralBonusSum,2) }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Share Profit Bonus</div><div class="text-2xl font-bold">{{ number_format($shareProfitBonusSum,2) }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Users Remaining Profit</div><div class="text-2xl font-bold">{{ number_format($usersRemainingProfit,2) }}</div></div>
    <div class="card"><div class="text-sm text-brand-300">Withdraw</div><div class="text-2xl font-bold">{{ number_format($withdrawSum,2) }}</div></div>
</div>

<div class="mt-6 card">
    <h2 class="text-lg font-semibold mb-2">Dream Consortium</h2>
    <div class="text-sm text-brand-300">Total Balance: <span class="font-bold text-white">{{ number_format($dreamStats['total_balance'],2) }}</span></div>
    <div class="text-sm text-brand-300">Share Profit: <span class="font-bold text-white">{{ number_format($dreamStats['share_profit'],2) }}</span></div>
    <div class="mt-3">
        <a href="#" class="btn bg-indigo-600 hover:bg-indigo-500">See detail</a>
    </div>
</div>
@endsection