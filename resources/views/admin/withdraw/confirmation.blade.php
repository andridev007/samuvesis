@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Withdraw Confirmation</h1>

@if(session('success'))
  <div class="mb-4 bg-green-600 px-4 py-2 rounded">{{ session('success') }}</div>
@endif

<div class="card">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b border-brand-700">
        <th class="py-2">Date&Time</th>
        <th>User</th>
        <th>Requested</th>
        <th>Fee (%)</th>
        <th>Method</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($reqs as $w)
      <tr class="border-b border-brand-800">
        <td class="py-2">{{ $w->tgl_wd }}</td>
        <td>{{ $w->id_user }}</td>
        <td>{{ number_format($w->nominal_wd,2) }}</td>
        <td>{{ number_format($w->fee_wd,2) }}</td>
        <td>{{ $w->method }}</td>
        <td>{{ $w->status_wd }}</td>
        <td class="flex gap-2 py-2">
          <form method="POST" action="{{ route('admin.withdraw.confirmation.approve', $w->id_wd) }}">
            @csrf
            <button class="btn bg-green-600 hover:bg-green-500">Approve</button>
          </form>
          <form method="POST" action="{{ route('admin.withdraw.confirmation.reject', $w->id_wd) }}">
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
    {{ $reqs->links() }}
  </div>
</div>
@endsection