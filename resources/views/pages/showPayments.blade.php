@extends('layouts.app')

@section('title', 'Payments - ' . $borrower->fname . ' ' . $borrower->lname)

@section('content')
  <div class="overflow-hidden mt-6 mx-4 rounded-lg border-gray-200">
    <div class="w-full p-6 rounded bg-blue-100">
      <p class="text-gray-700 text-sm">{{ $borrower->id }} </p>
      <h1 class="text-4xl font-bold">{{ $borrower->fname }} {{ $borrower->lname }}</h1>
      <p class="text-gray-600 mt-3">Loan ID: {{ $loan->id }}</p>
      <h2>Loan Payments</h2>
    </div>

    <div class="w-full p-6 bg-white rounded mt-4">
      @if($payments->count())
        <table class="w-full">
          <thead class="bg-gray-300 text-left">
            <tr>
              <th class="px-4 py-2">Reference ID</th>
              <th class="px-4 py-2">Term</th>
              <th class="px-4 py-2">Amount</th>
              <th class="px-4 py-2">Date Paid</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
              <tr class="border-b text-left border-gray-200 hover:bg-gray-50">
                <td class="px-4 py-2">{{ $payment->reference_id }}</td>
                <td class="px-4 py-2">{{ $payment->month }}</td>
                <td class="px-4 py-2">₱{{ number_format($payment->amount, 2) }}</td>
                <td class="px-4 py-2">{{ $payment->created_at->format('F j, Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-4">
          {{ $payments->links() }}
        </div>
      @else
        <p class="text-gray-500 italic">No payments have been made yet.</p>
      @endif

      <div class="mt-6">
        <a href="{{ route('loans.client', $borrower->id) }}" class="text-blue-600 hover:underline text-sm">
          ← Back to Loans
        </a>
      </div>
    </div>
  </div>
@endsection
