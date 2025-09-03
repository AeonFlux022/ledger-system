@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Payments</h1>

    @if($payments->count())
      <table class="w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Loan ID</th>
            <th class="px-4 py-2">Borrower</th>
            <th class="px-4 py-2">Reference ID</th>
            <th class="px-4 py-2">Month</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $index => $payment)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-4 py-2">{{ $index + 1 }}</td>
              <td class="px-4 py-2">{{ $payment->loan->id }}</td>
              <td class="px-4 py-2">
                {{ $payment->loan->borrower->fname }} {{ $payment->loan->borrower->lname }}
              </td>
              <td class="px-4 py-2 font-mono">{{ $payment->reference_id }}</td>
              <td class="px-4 py-2">{{ $payment->month }}</td>
              <td class="px-4 py-2">₱{{ number_format($payment->amount, 2) }}</td>
              <td class="px-4 py-2">{{ $payment->created_at->format('M d, Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4">
        {{ $payments->links() }}
      </div>
    @else
      <p class="mt-4 text-gray-500">No payments found.</p>
    @endif

  </div>
@endsection
