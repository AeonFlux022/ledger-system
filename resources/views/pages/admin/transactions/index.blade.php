@extends('layouts.admin')

@section('content')
  <h2 class="text-2xl font-bold mb-4">Transactions</h2>

  {{-- <a href="{{ route('pages.transactions.create', $loan->id) }}"
    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
    Add Transaction
  </a> --}}

  @if($transactions->count())
    <table class="w-full mt-4 border-collapse border">
      <thead class="text-left bg-gray-100">
        <tr>
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2">Transaction ID</th>
          <th class="border px-4 py-2">Amount</th>
          <th class="border px-4 py-2">Date</th>
          <th class="border px-4 py-2">Reference ID</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transactions as $transaction)
          <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2"></td>
            <td class="border px-4 py-2">{{ $transaction->id }}</td>
            <td class="border px-4 py-2">{{ number_format($transaction->amount, 2) }}</td>
            <td class="border px-4 py-2">{{ $transaction->created_at }}</td>
            <td class="border px-4 py-2">{{ $transaction->reference_id }}</td>

          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="mt-4 text-gray-500">No transactions found.</p>
  @endif
@endsection
