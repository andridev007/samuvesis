@extends('layouts.app')

@section('content')
<div class="card" x-data="joinForm()">
    <h2 class="text-xl font-semibold mb-4">New Join / Compound</h2>
    <form method="POST" action="{{ route('member.join.store') }}">
        @csrf
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm text-brand-300 mb-1">Program</label>
                <select name="id_prog" class="w-full bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
                    @foreach($programs as $prog)
                      <option value="{{ $prog->id_prog }}">{{ $prog->nama_prog }} (Min {{ number_format($prog->min_depo,0) }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-brand-300 mb-1">Method</label>
                <select name="method" x-model="method" class="w-full bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
                    <option value="manual">Manual</option>
                    <option value="profit">Profit</option>
                    <option value="bonus">Bonus</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-brand-300 mb-1">Nominal Join</label>
                <input type="number" step="0.01" name="nominal_join" x-model.number="nominal" class="w-full bg-brand-900 border border-brand-700 rounded-md px-3 py-2" required>
            </div>
        </div>

        <div class="grid md:grid-cols-4 gap-4 mt-4">
            <div class="card"><div class="text-sm text-brand-300">Nominal</div><div class="text-xl font-bold" x-text="format(nominal)"></div></div>
            <div class="card"><div class="text-sm text-brand-300">License 10%</div><div class="text-xl font-bold" x-text="format(license)"></div></div>
            <div class="card"><div class="text-sm text-brand-300">Unique Code</div><div class="text-xl font-bold" x-text="kodeUnik"></div></div>
            <div class="card"><div class="text-sm text-brand-300">Total</div><div class="text-xl font-bold" x-text="format(total)"></div></div>
        </div>

        <div class="mt-4">
            <label class="block text-sm text-brand-300 mb-1">Catatan</label>
            <textarea name="note" class="w-full bg-brand-900 border border-brand-700 rounded-md px-3 py-2" rows="3"></textarea>
        </div>

        <div class="mt-4">
            <button class="btn">Submit</button>
            <span class="text-xs text-brand-300 ml-2">Metode Profit/Bonus akan memotong saldo sesuai total (termasuk lisensi + kode unik).</span>
        </div>
    </form>
</div>

<script>
function joinForm(){
  return {
    method: 'manual',
    nominal: 0,
    kodeUnik: Math.floor(100 + Math.random()*900),
    get license() { return Math.round(this.nominal * 0.10 * 100) / 100; },
    get total() { return Number(this.nominal) + this.license + this.kodeUnik; },
    format(v){ return new Intl.NumberFormat().format(v ?? 0); }
  }
}
</script>
@endsection