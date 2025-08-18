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
      <th class="px-4 p-2">Interest Rate</th>
      <th class="px-4 p-2">Terms</th>
      <th class="px-4 p-2">Due Date</th>
      <th class="px-4 p-2">Status</th>
      <th class="px-4 p-2">Actions</th>
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
      <td class="px-4 py-2">{{ $loan->interest_rate }}%</td>
      <td class="px-4 py-2">{{ $loan->terms }} months</td>
      <td class="px-4 py-2">{{ $loan->due_date }}</td>
      <td class="px-4 py-2 capitalize">{{ $loan->status }}</td>
      <td class="px-4 py-2">
      <a href="{{ route('admin.loans.show', $loan->id) }}" class="inline-block bg-blue-600 text-white
      text-sm px-3 py-1 rounded hover:bg-blue-700 transition">View</a>
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
