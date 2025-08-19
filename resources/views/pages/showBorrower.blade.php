@extends('layouts.app')

@section('title', 'ABG Finance - Borrower Details')

@section('content')
  <div class="mx-auto bg-gray shadow-lg overflow-hidden mt-6">
    <div class="flex flex-col md:flex-row">
    <div class="md:w-2/3 p-6">
      <div class="mb-4">
      <span class="text-gray-700 italic">Borrower ID: {{ $borrower->id }} </span>
      </div>
      <h1 class="text-4xl font-bold mb-2">{{ $borrower->fname }} {{ $borrower->lname }}</h1>
      <p class="italic mb-6">Account created at {{ $borrower->created_at->format('F d, Y') }}</p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="text" value="{{ $borrower->email }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" value="{{ $borrower->contact_number }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" value="{{ $borrower->address }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Income</label>
        <input type="text" value="₱{{ number_format($borrower->income, 2) }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Employment Status</label>
        <input type="text" value="{{ ucwords($borrower->employment_status) }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">ID Provided</label>
        <input type="text" value="{{ ucwords(str_replace('_', ' ', $borrower->id_card)) }}" readonly
        class="px-3 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>
      </div>

      <hr class="mt-8 bg-gray-300">
      <div class="mt-8">
      <a href="{{ route('loans.client', $borrower->id) }}"
        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
        View Loans
      </a>
      </div>
      <div class="mt-6">
      <a href="{{ route('borrowers.client') }}" class="text-blue-600 hover:underline text-sm">
        ← Back to list
      </a>
      </div>
    </div>

    <!-- ID Image -->
    <div class="md:w-1/3 bg-gray-100 flex items-center justify-center p-6">
      <img src="{{ $borrower->id_image ? asset($borrower->id_image) : asset('images/placeholder.png') }}" alt="ID Image"
      class="object-cover rounded-lg border">
    </div>
    </div>
  </div>
@endsection
