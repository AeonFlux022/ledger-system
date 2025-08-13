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
      </tr>
    </thead>
    <tbody>
      @foreach($loans as $loan)
      <tr class="border-b border-gray-200 hover:bg-gray-50">
      <td class="px-4 py-2">{{ $loop->iteration }}</td>
      <td class="px-4 p-2r">{{ $loan->borrower->fname }} {{ $loan->borrower->lname }}</td>
      <td class="px-4 p-2">&#8369;{{ number_format($loan->loan_amount, 2) }}</td>
      <td class="px-4 p-2">{{ $loan->interest_rate }}%</td>
      <td class="px-4 p-2">{{ $loan->terms }} months</td>
      <td class="px-4 p-2">{{ $loan->due_date }}</td>
      <td class="px-4 p-2 capitalize">{{ $loan->status }}</td>
      </tr>
    @endforeach
    </tbody>
    </table>

    <div class="mt-4">
    {{ $loans->links() }}
    </div>
  </div>
@endsection
