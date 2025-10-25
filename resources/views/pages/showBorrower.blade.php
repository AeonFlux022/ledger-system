@extends('layouts.app')

@section('title', 'ABG Finance - Borrower Details')

@section('content')
  <div class="bg-white shadow-lg overflow-hidden mt-6 mx-4 rounded-lg">
    <div class="p-4 border-b border-gray-200">
      <div class="flex flex-col md:flex-row space-x-4">
        <div class="md:w-2/3 p-4">
          <div class="mb-2">
            <span class="text-gray-700 text-sm">{{ $borrower->id }} </span>
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
              <label class="block text-sm font-medium text-gray-700">Income <span class="text-xs">(Average income per
                  month)</span></label>
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

          <div class="mt-8 flex space-x-4">
            <a href="{{ route('loans.client', $borrower->id) }}"
              class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
              View Loans
            </a>
            <a href="{{ route('showStatement', $borrower->id) }}"
              class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
              View Statement
            </a>
            {{-- <a href="{{ route('paymentsList', ['borrower' => $borrower->id, 'loan' => $loan->id]) }}"
              class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
              View Payments
            </a> --}}
          </div>
          <div class="mt-6">
            <a href="{{ route('borrowersList') }}" class="text-blue-600 hover:underline text-sm">
              ← Back to list
            </a>
          </div>
        </div>

        <!-- ID Image -->
        <div class="md:w-1/3 bg-gray-100 flex items-center justify-center p-6">
          <img src="{{ $borrower->id_image ? asset($borrower->id_image) : asset('images/placeholder.png') }}"
            alt="ID Image" class="object-cover rounded-lg border">
        </div>
      </div>
    </div>
@endsection
