@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Admin Settings</h1>

@if(session('success'))
  <div class="mb-4 bg-green-600 px-4 py-2 rounded">{{ session('success') }}</div>
@endif

<div class="grid md:grid-cols-2 gap-6">
  <div class="card">
    <h2 class="text-lg font-semibold mb-3">Referral Setting</h2>
    <form method="POST" action="{{ route('admin.settings.referral.save') }}">
      @csrf
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-brand-700">
            <th class="py-2">Level</th>
            <th>Percent (%)</th>
          </tr>
        </thead>
        <tbody>
        @foreach($referral as $r)
          <tr class="border-b border-brand-800">
            <td class="py-2">{{ $r->level_referral_setting }}</td>
            <td>
              <input type="number" step="0.01" name="levels[{{ $r->level_referral_setting }}]" value="{{ $r->persen_referral_setting }}" class="bg-brand-900 border border-brand-700 rounded-md px-2 py-1 w-24">
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <button class="btn mt-3">Save</button>
    </form>
  </div>

  <div class="card">
    <h2 class="text-lg font-semibold mb-3">Profit Setting (Network Share)</h2>
    <form method="POST" action="{{ route('admin.settings.profit.save') }}">
      @csrf
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-brand-700">
            <th class="py-2">Level</th>
            <th>Percent (%)</th>
          </tr>
        </thead>
        <tbody>
        @foreach($profit as $p)
          <tr class="border-b border-brand-800">
            <td class="py-2">{{ $p->level_profit_setting }}</td>
            <td>
              <input type="number" step="0.01" name="levels[{{ $p->level_profit_setting }}]" value="{{ $p->persen_profit_setting }}" class="bg-brand-900 border border-brand-700 rounded-md px-2 py-1 w-24">
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <button class="btn mt-3">Save</button>
    </form>
  </div>

  <div class="card md:col-span-2">
    <h2 class="text-lg font-semibold mb-3">Program Setting</h2>
    <form method="POST" action="{{ route('admin.settings.program.save') }}" class="grid md:grid-cols-6 gap-3">
      @csrf
      <input type="text" name="id_prog" placeholder="ID Program" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <select name="id_group" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
        <option value="daily">Daily</option>
        <option value="dream">Dream</option>
      </select>
      <input type="text" name="nama_prog" placeholder="Nama Program" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <input type="number" step="0.01" name="hrg_prog" placeholder="Rate" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2">
      <input type="number" step="1" name="min_depo" placeholder="Min. Deposit" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <input type="number" step="1" name="est_balik" placeholder="Estimate Return (days)" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2">
      <input type="number" step="1" name="est_terima" placeholder="Estimate Receipt (days)" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2">
      <button class="btn md:col-span-6">Save Program</button>
    </form>

    <div class="mt-4">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-brand-700">
            <th class="py-2">ID</th><th>Group</th><th>Nama</th><th>Rate</th><th>Min Deposit</th>
          </tr>
        </thead>
        <tbody>
        @foreach($programs as $prog)
          <tr class="border-b border-brand-800">
            <td class="py-2">{{ $prog->id_prog }}</td>
            <td>{{ $prog->id_group }}</td>
            <td>{{ $prog->nama_prog }}</td>
            <td>{{ number_format($prog->hrg_prog,2) }}</td>
            <td>{{ number_format($prog->min_depo,0) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <h2 class="text-lg font-semibold mb-3">Join Setting</h2>
    <form method="POST" action="{{ route('admin.settings.join.save') }}">
      @csrf
      <label class="block text-sm text-brand-300">Minimum Join</label>
      <input type="number" step="1" name="min_join" value="{{ $joinSetting->min_join ?? 100000 }}" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <button class="btn mt-3">Save</button>
    </form>
  </div>

  <div class="card">
    <h2 class="text-lg font-semibold mb-3">Withdraw Setting</h2>
    <form method="POST" action="{{ route('admin.settings.withdraw.save') }}">
      @csrf
      <label class="block text-sm text-brand-300">Minimum Withdraw</label>
      <input type="number" step="1" name="min_withdraw" value="{{ $withdrawSetting->min_withdraw ?? 100000 }}" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <label class="block text-sm text-brand-300 mt-2">Fee (%)</label>
      <input type="number" step="0.01" name="fee_withdraw" value="{{ $withdrawSetting->fee_withdraw ?? 3.12 }}" class="bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
      <button class="btn mt-3">Save</button>
    </form>
  </div>
</div>
@endsection