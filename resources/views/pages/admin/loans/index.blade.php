@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Loans</h1>
    <div class="flex items-center justify-between mb-4">
      {{-- Left: Create Loan Button --}}
      <x-modals.create-loan :borrowers="$borrowers" />
      {{-- Right: Export PDF Button --}}
      <a href="{{ route('export.loans') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Export Loans as PDF
      </a>
    </div>

    <table class="w-full bg-white shadow-md rounded">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="px-4 p-2">No.</th>
          <th class="px-4 p-2">Borrower</th>
          <th class="px-4 p-2">Loan Amount</th>
          <th class="px-4 p-2">Due Date</th>
          <th class="px-4 py-2">Outstanding Balance</th>
          <th class="px-4 p-2">Last Payment</th>
          <th class="px-4 p-2">Actions</th>
          <th class="px-4 p-2">Status</th>

        </tr>
      </thead>
      <tbody>
        @forelse($loans as $loan)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-2">
              {{ ($loans->currentPage() - 1) * $loans->perPage() + $loop->iteration }}
            </td>
            <td class="px-4 py-2">{{ $loan->borrower->fname }} {{ $loan->borrower->lname }}</td>
            <td class="px-4 py-2">&#8369;{{ number_format($loan->loan_amount, 2) }}</td>
            <td class="px-4 py-2">{{ $loan->due_date }}</td>
            <td class="px-4 py-2">₱{{ number_format($loan->display_balance, 2) }}</td>
            <td class="px-4 py-2">{{ $loan->last_payment_date }}</td>
            <td class="px-4 py-2">
              <div class="flex items-center space-x-2">

                {{-- View --}}
                <a href="{{ route('admin.loans.show', $loan->id) }}"
                  class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
                  View
                </a>

                {{-- Edit --}}
                @if(in_array($loan->status, ['approved', 'rejected']))
                  <button class="bg-gray-400 text-white text-sm px-4 py-2 rounded cursor-not-allowed" disabled>
                    Edit
                  </button>
                @else
                  <x-modals.edit-loan :loan="$loan" :borrowers="$borrowers" />
                @endif

                {{-- Delete --}}
                @if(in_array($loan->status, ['approved']) || $loan->loan_status === 'completed')
                  <button disabled class="bg-gray-400 text-white text-sm px-4 py-2 rounded cursor-not-allowed">
                    Delete
                  </button>
                @else
                  <button onclick="openDeleteLoanModal('{{ route('admin.loans.destroy', $loan->id) }}')"
                    class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">
                    Delete
                  </button>
                @endif


              </div>
            </td>

            <td class="px-4 py-2 capitalize rounded">
              @if($loan->status === 'approved')
                @if($loan->loan_status === 'current')
                  <span class="bg-teal-200 text-teal-800 px-4 py-2 rounded">Current</span>
                @elseif($loan->loan_status === 'overdue')
                  <span class="bg-orange-200 text-orange-800 px-4 py-2 rounded">Overdue</span>
                @elseif($loan->loan_status === 'completed')
                  <span class="bg-blue-200 text-blue-800 px-4 py-2 rounded">Completed</span>
                @endif
              @elseif($loan->status === 'pending')
                <span class="bg-yellow-200 text-yellow-800 px-4 py-2 rounded">Pending</span>
              @elseif($loan->status === 'rejected')
                <span class="bg-red-200 text-red-800 px-4 py-2 rounded">Rejected</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
              No loans found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $loans->links() }}
    </div>
  </div>
@endsection

<x-modals.delete-loan />
