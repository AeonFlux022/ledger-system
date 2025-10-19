@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Loans</h1>
    <x-modals.create-loan :borrowers="$borrowers" />

    <table class="w-full bg-white shadow-md rounded">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="px-4 p-2">#</th>
          <th class="px-4 p-2">Borrower</th>
          <th class="px-4 p-2">Loan Amount</th>
          {{-- <th class="px-4 p-2">Interest Rate</th> --}}
          {{-- <th class="px-4 p-2">Terms</th> --}}
          <th class="px-4 p-2">Due Date</th>
          <th class="px-4 py-2">Outstanding Balance</th>
          {{-- <th class="px-4 p-2">Loan Status</th> --}}
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
              {{-- <td class="px-4 py-2">{{ $loan->interest_rate }}%</td> --}}
              {{-- <td class="px-4 py-2">{{ $loan->terms }} months</td> --}}
              <td class="px-4 py-2">{{ $loan->due_date }}</td>
              <td class="px-4 py-2">₱{{ number_format($loan->balance_with_overdue, 2) }}</td>
              {{-- <td
                class="px-4 py-2 {{ $loan->loan_status === 'Overdue' ? 'text-red-600 font-bold' : 'text-green-600 font-bold' }}">
                {{ $loan->loan_status }} --}}
              </td>
              <td class="px-4 py-2">{{ $loan->last_payment_date }}</td>
              <td class="px-4 py-2">
                <div class="flex items-center space-x-2">
                  <a href="{{ route('admin.loans.show', $loan->id) }}"
                    class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">View</a>

                  @if($loan->status === 'approved')
                    <button class="bg-gray-400 text-white text-sm px-4 py-2 rounded cursor-not-allowed" disabled>
                      Edit Loan
                    </button>
                  @else
                    <x-modals.edit-loan :loan="$loan" :borrowers="$borrowers" />
                  @endif
                </div>
              </td>

              <td class="px-4 py-2 capitalize rounded
          {{ $loan->status === 'approved' ? 'bg-green-100 text-green-700' :
          ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
            ($loan->status === 'rejected' ? 'bg-red-100 text-red-700' :
              ($loan->status === 'completed' ? 'bg-blue-100 text-blue-700' :
                ($loan->status === 'overdue' ? 'bg-orange-100 text-orange-700' :
                  'bg-gray-100 text-gray-700')))) }}">
                {{ $loan->status }}
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
