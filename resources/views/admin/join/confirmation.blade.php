@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Join Confirmation</h1>

@if(session('success'))
  <div class="mb-4 bg-green-600 px-4 py-2 rounded">{{ session('success') }}</div>
@endif

<div class="card">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b border-brand-700">
        <th class="py-2">Date&Time</th>
        <th>Name</th>
        <th>Program</th>
        <th>Amount</th>
        <th>License 10%</th>
        <th>Total</th>
        <th>Method</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($joins as $j)
      <tr class="border-b border-brand-800">
        <td class="py-2">{{ $j->tgl_join }}</td>
        <td>{{ $j->id_user }}</td>
        <td>{{ $j->id_prog }}</td>
        <td>{{ number_format($j->nominal_join,2) }}</td>
        <td>{{ number_format($j->insurance,2) }}</td>
        <td>{{ number_format($j->total_bayar,2) }}</td>
        <td>{{ $j->method }}</td>
        <td class="flex gap-2 py-2">
          <form method="POST" action="{{ route('admin.join.confirmation.approve', $j->id_join) }}">
            @csrf
            <button class="btn bg-green-600 hover:bg-green-500">Approve</button>
          </form>
          <form method="POST" action="{{ route('admin.join.confirmation.reject', $j->id_join) }}">
            @csrf
            <input type="text" name="note" placeholder="Note" class="bg-brand-900 border border-brand-700 rounded-md px-2 py-1">
            <button class="btn bg-red-600 hover:bg-red-500">Reject</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="mt-4">
    {{ $joins->links() }}
  </div>
</div>
@endsection