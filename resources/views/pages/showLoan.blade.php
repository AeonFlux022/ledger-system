@extends('layouts.app')

@section('title', 'ABG Finance - Borrower Loans')

@section('content')
  <div class="overflow-hidden mt-6 mx-4 rounded-lg border-gray-200 ">
    <div class="flex flex-row md:flex-col space-y-4 ">
      <div class="w-full p-6 rounded bg-blue-100">
        <div class="flex justify-between items-center">
          <div class="space-y-2">
            <p class="text-gray-700 text-sm">{{ $borrower->id }} </p>
            <h1 class="text-4xl font-bold">{{ $borrower->fname }} {{ $borrower->lname }}</h1>
            <h2>Loan Applications</h2>

          </div>
          <div>
            <x-modals.create-loan :borrower="$borrower" />
          </div>
        </div>

      </div>
      <div class="w-full p-6 bg-white rounded">
        @if ($loans->count())
          <table class="w-full">
            <thead class="bg-gray-300 text-left">
              <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Loan ID</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Terms</th>
                <th class="px-4 py-2">Monthly Payment</th>
                <th class="px-4 py-2">Outstanding Balance</th>
                <th class="px-4 py-2">Loan Status</th>
                <th class="px-4 py-2">Actions</th>
                <th class="px-4 py-2">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($loans as $loan)
                <tr class="border-b text-left border-gray-200 hover:bg-gray-50">
                  <td class="px-4 py-2">{{ $loop->iteration }}</td>
                  <td class="px-4 py-2">{{ $loan->id }}</td>
                  <td class="px-4 py-2">₱{{ number_format($loan->loan_amount, 2) }}</td>
                  <td class="px-4 py-2">{{ $loan->terms }} months</td>
                  <td class="px-4 py-2">₱{{ number_format($loan->monthly_amortization, 2) }}</td>
                  <td class="px-4 py-2"> ₱{{ number_format($loan->outstanding_balance + $loan->calculateOverdues(), 2) }}</td>
                  <td class="px-4 py-2">
                    <span
                      class="{{ $loan->loan_status === 'Overdue' ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold' }}">
                      {{ $loan->loan_status }}
                    </span>
                  </td>
                  <td class="px-4 py-2">
                    @if ($loan->status === 'approved')
                      <a href="{{ route('loans.schedule', [$borrower->id, $loan->id]) }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        View Schedule
                      </a>
                      <a href="{{ route('paymentsList', [$borrower->id, $loan->id]) }}"
                        class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 mt-2">
                        View Payments
                      </a>
                    @else
                      <span class="text-gray-500 italic">Not available</span>
                    @endif
                  </td>
                  <td
                    class="px-4 py-2 {{ $loan->status === 'approved' ? 'bg-green-100 text-green-700' : ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ ucfirst($loan->status) }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="mt-4">
            {{ $loans->links() }}
          </div>
        @else
          <p class="text-gray-500">This borrower has no loans yet.</p>
        @endif

        <div class="mt-6">
          <a href="{{ route('showBorrower', $borrower->id) }}" class="text-blue-600 hover:underline text-sm">
            ← Back to Profile
          </a>
        </div>
      </div>
@endsection
