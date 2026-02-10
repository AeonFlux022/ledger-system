@extends('layouts.admin')

@section('title', 'ABG Finance - Loan Details')

@section('content')
  <div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-2">Loan Details</h1>
    <p class="text-sm text-gray-500 mb-6">
      Submitted at {{ $loan->created_at->format('F j, Y g:i A') }}
    </p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 space-y-8">
      <!-- Borrower Details -->
      <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Borrower Details</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
          <div>
            <label class="text-sm text-gray-500">Borrower ID</label>
            <p class="mt-1 font-medium">{{ $loan->borrower->id }}</p>
          </div>
          <div></div>
          <div>
            <label class="text-sm text-gray-500">Full Name</label>
            <p class="mt-1 font-medium">{{ $loan->borrower->fname }} {{ $loan->borrower->lname }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Email</label>
            <p class="mt-1 font-medium">{{ $loan->borrower->email }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Contact Number</label>
            <p class="mt-1 font-medium">{{ $loan->borrower->contact_number }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="text-sm text-gray-500">Address</label>
            <p class="mt-1 font-medium">{{ $loan->borrower->address }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Income <span class="text-xs">(Average per month)</span></label>
            <p class="mt-1 font-medium">₱{{ number_format($loan->borrower->income, 2) }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Employment Status</label>
            <p class="mt-1 font-medium">{{ ucwords($loan->borrower->employment_status) }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">ID Provided</label>
            <p class="mt-1 font-medium">{{ ucwords(str_replace('_', ' ', $loan->borrower->id_card)) }}</p>
          </div>
        </div>
      </div>
      <hr>

      <!-- Loan Info -->
      <h3 class="text-lg font-bold text-gray-800 mb-4">Loan Details</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
        <div>
          <label class="text-sm text-gray-500">Loan ID</label>
          <p class="mt-1 font-medium">{{ $loan->id }}</p>
        </div>
        <div></div>
        <div>
          <label class="text-sm text-gray-500">Loan Amount</label>
          <p class="mt-1 font-medium">&#x20B1;{{ number_format($loan->loan_amount, 2) }}</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Interest Rate</label>
          <p class="mt-1 font-medium">{{ $loan->interest_rate }}% per month</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Terms</label>
          <p class="mt-1 font-medium">{{ $loan->terms }} months</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Processing Fee</label>
          <p class="mt-1 font-medium">&#x20B1;{{ number_format($loan->processing_fee, 2) }}</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Total Payable</label>
          <p class="mt-1 font-bold text-gray-800">
            &#x20B1;{{ number_format($loan->remaining_balance, 2) }}
        </div>
        <div>
          <label class="text-sm text-gray-500">Monthly Amortization</label>
          <p class="mt-1 font-medium">&#x20B1;{{ number_format($loan->monthly_amortization, 2) }}</p>
        </div>
        <div class="mt-4">
          <h4 class="text-sm text-gray-500">Overdue Penalties</h4>
          <p class="mt-1 font-medium text-red-600">
            &#x20B1;{{ number_format($loan->overdue, 2) }}
          </p>
        </div>


      </div>
      <hr>

      <!-- Amortization Table -->
      <h3 class="text-lg font-bold text-gray-800 mb-4">Amortization Schedule</h3>
      <table class="w-full">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-2">Month</th>
            <th class="px-4 py-2">Due Date</th>
            <th class="px-4 py-2">Amount</th>
            {{-- <th class="px-4 py-2">Penalty</th> --}}
            <th class="px-4 py-2">Total Payable</th>

            @if($loan->status == 'approved')
              <th class="px-4 py-2">Action</th>
              <th class="px-4 py-2">Date Paid</th>
            @endif
          </tr>
        </thead>

        <tbody>
          @foreach($paginatedSchedule as $payment)
            @php
              $paid = $loan->payments->firstWhere('month', $payment['month']);

              if ($paid) {
                // use stored DB values
                $penalty = $paid->penalty;
                $totalPayable = $paid->total_paid;
              } else {
                // compute live penalty
                $penalty = $loan->calculatePenaltyForMonth($payment['month']);
                $totalPayable = $payment['amount'] + $penalty;
              }
            @endphp
            <tr class="border-b border-gray-200 hover:bg-gray-50 text-left">
              <td class="px-4 py-2">{{ $payment['month'] }}</td>
              <td class="px-4 py-2">
                {{ \Carbon\Carbon::parse($payment['due_date'])->format('M jS, Y') }}
              </td>
              <td class="px-4 py-2">
                &#x20B1;{{ number_format($payment['amount'], 2) }}
                @if($penalty > 0)
                  <span class="text-xs text-red-600 block">(+₱{{ number_format($penalty, 2) }} penalty)</span>
                @endif
              </td>
              {{-- <td class="px-4 py-2">₱{{ number_format($penalty, 2) }}</td> --}}
              <td class="px-4 py-2">&#x20B1;{{ number_format($totalPayable, 2) }}</td>
              @if($loan->status == 'approved')
                <td class="px-4 py-2">
                  @if($paid)
                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                      Term Paid
                    </button>
                  @else
                    <x-modals.create-payment :loan="$loan" :payment="$payment" />
                  @endif
                </td>
                <td class="px-4 py-2">
                  @if($paid)
                    {{ $paid->created_at->format('F j, Y') }}
                  @else
                    <span class="text-gray-400 italic">—</span>
                  @endif
                </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4">
        {{ $paginatedSchedule->links() }}
      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-2 mt-6">
        @if($loan->status === 'pending')
          <form method="POST" action="{{ route('admin.loans.approve', $loan->id) }}">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
              Approve
            </button>
          </form>

          <x-modals.decline-loan :loan="$loan" />

          {{-- <form method="POST" action="{{ route('admin.loans.decline', $loan->id) }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
              Decline
            </button>
          </form> --}}
        @endif
      </div>

    </div>

    <div class="mt-6">
      <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline text-sm">← Back to list</a>
    </div>
  </div>
@endsection
