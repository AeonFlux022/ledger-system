@extends('layouts.app')

@section('title', 'ABG Finance - Loan Schedule')

@section('content')
  <div class="overflow-hidden mt-6 mx-4 rounded-lg border-gray-200">
    <div class="flex flex-row md:flex-col space-y-4">

      <!-- Borrower Info -->
      <div class="w-full p-6 rounded bg-blue-100">
        <div class="flex justify-between items-center">
          <div class="space-y-2">
            <p class="text-gray-700 text-sm">Borrower ID: {{ $borrower->id }}</p>
            <h1 class="text-4xl font-bold">{{ $borrower->fname }} {{ $borrower->lname }}</h1>
          </div>
        </div>
      </div>

      <!-- Loan Details (same format as admin side) -->
      <div class="w-full p-6 bg-white rounded shadow-sm">
        @php
          $overdues = $loan->calculateOverdues();
          $totalBalance = $loan->outstanding_balance + $overdues;
        @endphp

        <h3 class="text-xl font-semibold mb-4">Loan Details</h3>
        <table class="w-full border-gray-200 rounded">
          <tbody>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-2 font-medium">Loan ID</td>
              <td class="px-4 py-2">{{ $loan->id }}</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-2 font-medium">Loan Amount</td>
              <td class="px-4 py-2">₱{{ number_format($loan->loan_amount, 2) }}</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-2 font-medium">Terms</td>
              <td class="px-4 py-2">{{ $loan->terms }} months</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-2 font-medium">Monthly Payment</td>
              <td class="px-4 py-2">₱{{ number_format($loan->monthly_amortization, 2) }}</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-2 font-medium">Outstanding Balance</td>
              <td class="px-4 py-2">
                ₱{{ number_format($totalBalance, 2) }}
                @if ($overdues > 0)
                  <span class="text-xs text-red-600 font-medium">
                    (includes ₱{{ number_format($overdues, 2) }} penalties)
                  </span>
                @endif
              </td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="px-4 py-3 font-medium">Loan Status</td>
              <td class="px-4 py-2">
                @if($loan->loan_status === 'current')
                  <span class="bg-teal-200 text-teal-800 px-4 py-2 rounded">Current</span>
                @elseif($loan->loan_status === 'overdue')
                  <span class="bg-orange-200 text-orange-800 px-4 py-2 rounded">Overdue</span>
                @elseif($loan->loan_status === 'completed')
                  <span class="bg-blue-200 text-blue-800 px-4 py-2 rounded">Completed</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="px-4 py-2 font-medium">Date Applied</td>
              <td class="px-4 py-2">{{ $loan->created_at->format('M d, Y') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Payment Schedule -->
      <div class="w-full p-6 bg-white rounded mt-6">
        <h3 class="text-xl font-semibold mb-4">Payment Schedule</h3>
        <table class="w-full">
          <thead class="bg-gray-300 text-left">
            <tr>
              <th class="px-4 py-2">No.</th>
              <th class="px-4 py-2">Due Date</th>
              <th class="px-4 py-2">Term</th>
              <th class="px-4 py-2">Monthly Amortization</th>
              <th class="px-4 py-2">Fines</th>
              <th class="px-4 py-2">Total Payable</th>
              <th class="px-4 py-2">Actions</th>
              <th class="px-4 py-2">Date Paid</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($paginatedSchedule as $row)
              @php
                $paid = $loan->payments->firstWhere('month', $row['month']);
                $dueDate = \Carbon\Carbon::parse($row['due_date']);
                $penalty = 0;

                if (!$paid && now()->greaterThan($dueDate)) {
                  $penalty = $row['amount'] * 0.03; // 3% penalty
                }

                // For this month only, add penalty if overdue
                $totalPayable = $row['amount'] + ($penalty > 0 ? $penalty : 0);
              @endphp
              <tr class="text-left border-b border-gray-200 hover:bg-gray-50">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $row['due_date'] }}</td>
                <td class="px-4 py-2">{{ $row['month'] }}</td>
                <td class="px-4 py-2">₱{{ number_format($row['amount'], 2) }}</td>
                <td class="px-4 py-2 {{ $penalty > 0 ? 'text-red-600 font-semibold' : '' }}">
                  ₱{{ number_format($penalty, 2) }}
                </td>
                <td class="px-4 py-2">
                  ₱{{ number_format($totalPayable, 2) }}
                </td>
                <td class="px-4 py-2">
                  @if($paid)
                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                      Term Paid
                    </button>
                  @else
                    <x-modals.create-payment :loan="$loan" :payment="$row" />
                  @endif
                </td>

                <!-- Date Paid -->
                <td class="px-4 py-2">
                  @if($paid)
                    {{ $paid->created_at->format('F j, Y') }}
                  @else
                    <span class="text-gray-400 italic">—</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-4">
          {{ $paginatedSchedule->links() }}
        </div>

        <div class="mt-6">
          <a href="{{ route('loans.client', $borrower->id) }}" class="text-blue-600 hover:underline text-sm">
            ← Back to Loans
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
