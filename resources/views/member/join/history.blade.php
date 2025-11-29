@extends('layouts.app')

@section('content')
<div class="card">
    <h2 class="text-xl font-semibold mb-4">Join History</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b border-brand-700">
                <th class="py-2">Date</th>
                <th>Program</th>
                <th>Nominal</th>
                <th>License</th>
                <th>Total</th>
                <th>Status</th>
                <th>Method</th>
            </tr>
        </thead>
        <tbody>
        @foreach($joins as $j)
            <tr class="border-b border-brand-800">
                <td class="py-2">{{ $j->tgl_join }}</td>
                <td>{{ $j->program?->nama_prog ?? $j->id_prog }}</td>
                <td>{{ number_format($j->nominal_join,2) }}</td>
                <td>{{ number_format($j->insurance,2) }}</td>
                <td>{{ number_format($j->total_bayar,2) }}</td>
                <td>{{ $j->status_join->value }}</td>
                <td>{{ $j->method->value }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $joins->links() }}
    </div>
</div>
@endsection