@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Withdraw History</h1>
<div class="card">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b border-brand-700">
        <th class="py-2">Date&Time</th>
        <th>User</th>
        <th>Requested</th>
        <th>Fee (%)</th>
        <th>Withdraw</th>
        <th>Method</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    @foreach($history as $w)
      <tr class="border-b border-brand-800">
        <td class="py-2">{{ $w->tgl_wd }}</td>
        <td>{{ $w->id_user }}</td>
        <td>{{ number_format($w->nominal_wd,2) }}</td>
        <td>{{ number_format($w->fee_wd,2) }}</td>
        <td>{{ number_format($w->wd_diterima,2) }}</td>
        <td>{{ $w->method }}</td>
        <td>{{ $w->status_wd }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="mt-4">
    {{ $history->links() }}
  </div>
</div>
@endsection