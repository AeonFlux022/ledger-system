@extends('layouts.app')

@section('title', 'ABG Finance - Borrower Loans')

@section('content')
  <div class="px-6 py-4 mx-auto bg-gray shadow-lg">
    <div class="mb-4">

    <span class="text-gray-700 italic">Borrower ID: {{ $borrower->id }} </span>
    <p class="italic mb-6">Account created at {{ $borrower->created_at->format('F d, Y') }}</p>
    <hr>
    </div>
    <h1 class="text-4xl font-bold mb-6">{{ $borrower->fname }} {{ $borrower->lname }}</h1>

    <x-modals.create-loan :borrower="$borrower" />
    @if ($loans->count())
    <table class="w-full">
    <thead class="bg-gray-300">
      <tr class="text-left">
      <th class="px-4 py-2">#</th>
      <th class="px-4 py-2">Amount</th>
      <th class="px-4 py-2">Terms</th>
      <th class="px-4 py-2">Monthly Payment</th>
      <th class="px-4 py-2">Total Payable</th>
      <th class="px-4 py-2">Status</th>
      <th class="px-4 py-2">Loan Applied</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($loans as $loan)
      <tr class="border-b border-gray-200 hover:bg-gray-50">
      <td class="px-4 py-2">{{ $loop->iteration }}</td>
      <td class="px-4 py-2">₱{{ number_format($loan->loan_amount, 2) }}</td>
      <td class="px-4 py-2">{{ $loan->terms }} months</td>
      <td class="px-4 py-2">₱{{ number_format($loan->monthly_amortization, 2) }}</td>
      <td class="px-4 py-2">₱{{ number_format($loan->total_payable, 2) }}</td>
      <td class="px-4 py-2">
      <span class="px-2 py-1 rounded 
      {{ $loan->status === 'approved' ? 'bg-green-100 text-green-700' :
      ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
      {{ ucfirst($loan->status) }}
      </span>
      </td>
      <td class="px-4 py-2">{{ $loan->created_at->format('M d, Y') }}</td>
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
    <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
      ← Back
    </a>
    </div>

  </div>

@endsection





{{-- <div class="max-w-4xl mx-auto mt-8 bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold mb-4">
    Loans of {{ $borrower->fname }} {{ $borrower->lname }}
  </h2>

  @if ($loans->count())
  <table class="w-full collapse gray-300">
    <thead>
      <tr class="bg-gray-100">
        <th class="px-4 py-2">#</th>
        <th class="px-4 py-2">Amount</th>
        <th class="px-4 py-2">Terms</th>
        <th class="px-4 py-2">Total Payable</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Created</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($loans as $loan)
      <tr>
        <td class="px-4 py-2">{{ $loop->iteration }}</td>
        <td class="px-4 py-2">₱{{ number_format($loan->loan_amount, 2) }}</td>
        <td class="px-4 py-2">{{ $loan->terms }} months</td>
        <td class="px-4 py-2">₱{{ number_format($loan->total_payable, 2) }}</td>
        <td class="px-4 py-2">
          <span class="px-2 py-1 rounded 
      {{ $loan->status === 'approved' ? 'bg-green-100 text-green-700' :
      ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
            {{ ucfirst($loan->status) }}
          </span>
        </td>
        <td class="px-4 py-2">{{ $loan->created_at->format('M d, Y') }}</td>
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
    <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
      ← Back
    </a>
  </div>
</div> --}}
