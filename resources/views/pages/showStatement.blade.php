@extends('layouts.app')

@section('title', 'ABG Finance')

@section('content')
  <div class="max-w-5xl mx-auto px-6 py-10">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Statement of Account</h1>
      <a href="{{ route('statementPdf', $borrower->id) }}"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm font-medium">
        Download PDF
      </a>
    </div>

    {{-- Borrower Details Card --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
      <h2 class="text-xl font-bold text-gray-700 border-b pb-2 mb-4">Borrower Details</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
        <p><strong>Name:</strong> {{ $borrower->fname }} {{ $borrower->lname }}</p>
        <p><strong>Phone:</strong> {{ $borrower->contact_number }}</p>
        <p><strong>Email:</strong> {{ $borrower->email ?? '—' }}</p>
        <p><strong>Address:</strong> {{ $borrower->address ?? '—' }}</p>
      </div>
    </div>

    {{-- Loans Section --}}
    @forelse($borrower->loans as $loan)
      <div class="bg-white shadow-md rounded-lg p-6 mb-10">
        <div class="flex items-center justify-between border-b pb-3 mb-4">
          <h3 class="text-xl font-bold text-gray-800">Loan ID: {{ $loan->id }}</h3>
          <span class="text-sm px-3 py-1 rounded-full 
                                                @if($loan->loan_status === 'current') bg-teal-100 text-teal-800 
                                                @elseif($loan->loan_status === 'overdue') bg-orange-100 text-orange-800 
                                                @elseif($loan->loan_status === 'completed') bg-blue-100 text-blue-800 
                                                @else bg-gray-100 text-gray-600 @endif">
            {{ ucfirst($loan->loan_status ?? 'N/A') }}
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 mb-6">
          <p><strong>Loan Amount:</strong> &#x20B1;{{ number_format($loan->loan_amount, 2) }}</p>
          <p><strong>Terms:</strong> {{ number_format($loan->terms) }} months</p>
          <p><strong>Outstanding Balance:</strong> &#x20B1;{{ number_format($loan->remaining_balance ?? 0, 2) }}</p>
          <p><strong>Payable per Term:</strong> &#x20B1;{{ number_format($loan->payable_per_term ?? 0, 2) }}</p>
          @php
            $startDate = \Carbon\Carbon::parse($loan->due_date);
            $endDate = $startDate->copy()->addMonths(max((int) $loan->terms - 1, 0));
          @endphp

          <p><strong>Start Date:</strong> {{ $startDate->format('M d, Y') }}</p>
          <p><strong>End Date:</strong> {{ $endDate->format('M d, Y') }}</p>

        </div>

        {{-- Payments Table --}}
        <h4 class="text-lg font-semibold text-gray-800 mb-3">Payment History</h4>

        <div class="overflow-x-auto">
          @php
            $totalPaid = $loan->payments->sum('total_paid');
            $totalPenalty = $loan->payments->sum('penalty');
            $finalBalance = $loan->remaining_balance;
          @endphp
          <table class="w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
              <tr>
                <th class="px-4 py-2 border">No. of Payments</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Starting Balance</th>
                <th class="px-4 py-2 border">Monthly Amount Due</th>
                <th class="px-4 py-2 border">Penalties</th>
                <th class="px-4 py-2 border">Total Payable Amount</th>
                <th class="px-4 py-2 border">Payment Received</th>
                <th class="px-4 py-2 border">Remaining Balance</th>

              </tr>
            </thead>
            <tbody class="text-gray-700">
              @forelse($loan->payments as $payment)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                  <td class="px-4 py-2 border">{{ $payment->created_at->format('M d, Y') }}</td>
                  <td class="px-4 py-2 border text-right">
                    &#x20B1;{{ number_format($loan->startingBalanceBefore($payment), 2) }}
                  </td>

                  <td class="px-4 py-2 border text-right">{{ number_format($loan->monthly_amortization, 2) }}</td>
                  <td class="px-4 py-2 border text-right">
                    &#x20B1;{{ number_format($payment->penalty, 2) }}
                  </td>
                  <td class="px-4 py-2 border text-right">{{ number_format($payment->total_paid, 2) }}</td>
                  <td class="px-4 py-2 border text-right">
                    &#x20B1;{{ number_format($loan->runningTotalPaid($payment), 2) }}
                  <td class="px-4 py-2 border text-right">
                    &#x20B1;{{ number_format($loan->runningBalanceAfter($payment), 2) }}
                  </td>
                  {{-- <td class="px-4 py-2 border text-center">{{ $payment->reference_id }}</td> --}}
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-gray-500 py-4">No payments recorded.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <div class="mt-4 bg-gray-50 border rounded-lg p-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
            <div>
              <p class="text-gray-500">Total Paid</p>
              <p class="text-lg font-bold text-gray-800">
                &#x20B1;{{ number_format($totalPaid, 2) }}
              </p>
            </div>

            <div>
              <p class="text-gray-500">Total Penalties</p>
              <p class="text-lg font-bold text-red-600">
                &#x20B1;{{ number_format($totalPenalty, 2) }}
              </p>
            </div>

            <div>
              <p class="text-gray-500">Remaining Balance</p>
              <p class="text-lg font-bold text-green-700">
                &#x20B1;{{ number_format($finalBalance, 2) }}
              </p>
            </div>
          </div>

        </div>
      </div>
    @empty
      <div class="bg-white shadow rounded p-6 text-center text-gray-600">
        No loans found for this borrower.
      </div>
    @endforelse

    {{-- Back Link --}}
    <div class="mt-6">
      <a href="{{ route('showBorrower', $borrower->id) }}" class="text-blue-600 hover:underline text-sm">
        ← Back to Profile
      </a>
    </div>
  </div>
@endsection
