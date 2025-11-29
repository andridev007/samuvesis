@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-4">
    <div class="card md:col-span-1">
        <div class="text-sm text-brand-300 mb-2">Account Balance</div>
        <div class="bg-gradient-to-r from-pink-500 to-orange-400 rounded-xl p-4 text-brand-900 mb-4">
            <div class="flex justify-between">
                <div>
                    <div class="text-sm">Main Wallet</div>
                    <div class="text-2xl font-bold">$0.00</div>
                </div>
                <div class="text-right">
                    <div class="text-sm">Profit Wallet</div>
                    <div class="text-2xl font-bold">${{ number_format($remainingShareProfit, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('member.join.index') }}" class="btn bg-green-600 hover:bg-green-500">Invest Now</a>
            <a href="#" class="btn bg-yellow-600 hover:bg-yellow-500">Withdraw</a>
        </div>
    </div>

    <div class="md:col-span-2 space-y-4">
        <div class="card">
            <div class="text-sm text-brand-300 mb-2">Referral URL</div>
            @php $ref = url('/signup?ref=' . (auth()->user()->referral ?? '')); @endphp
            <div class="flex items-center gap-2">
                <input class="flex-1 bg-brand-900 border border-brand-700 rounded-md px-3 py-2" readonly value="{{ $ref }}">
                <button class="btn bg-rose-600 hover:bg-rose-500" onclick="copyToClipboard('{{ $ref }}')">Copy</button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="card"><div class="text-brand-300 text-sm">Effective Balance</div><div class="text-2xl font-bold">{{ number_format($effectiveBalance,2) }}</div></div>
            <div class="card"><div class="text-brand-300 text-sm">Remaining Share Profit</div><div class="text-2xl font-bold">{{ number_format($remainingShareProfit,2) }}</div></div>
            <div class="card"><div class="text-brand-300 text-sm">Referral Bonus</div><div class="text-2xl font-bold">{{ number_format($referralBonus,2) }}</div></div>
            <div class="card"><div class="text-brand-300 text-sm">Share Profit Bonus</div><div class="text-2xl font-bold">{{ number_format($shareProfitBonus,2) }}</div></div>
            <div class="card"><div class="text-brand-300 text-sm">Remaining Bonus</div><div class="text-2xl font-bold">{{ number_format($remainingBonus,2) }}</div></div>
            <div class="card"><div class="text-brand-300 text-sm">Withdraw</div><div class="text-2xl font-bold"><a href="#" class="underline">Request</a></div></div>
        </div>
    </div>
</div>
@endsection