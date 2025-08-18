@extends('layouts.admin')

@section('title', 'ABG Finance - Borrower Details')

@section('content')
  <div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Borrower Details</h1>
    <p class="text-sm text-gray-500 mb-6">
    Submitted at {{ $borrower->created_at->format('F j, Y g:i A') }}
    </p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
      <div>
      <label class="text-sm text-gray-500">First Name</label>
      <p class="mt-1 font-medium">{{ $borrower->fname }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Last Name</label>
      <p class="mt-1 font-medium">{{ $borrower->lname }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Address</label>
      <p class="mt-1 font-medium">{{ $borrower->address }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Contact Number</label>
      <p class="mt-1 font-medium">{{ $borrower->contact_number }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Email</label>
      <p class="mt-1 font-medium">{{ $borrower->email }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">ID Type</label>
      <p class="mt-1 font-medium">{{ ucwords(str_replace('_', ' ', $borrower->id_card)) }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Income</label>
      <small class="block text-xs text-gray-400">Average income per month</small>
      <p class="mt-1 font-medium">₱{{ number_format($borrower->income, 2) }}</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Employment Status</label>
      <p class="mt-1 font-medium">{{ ucfirst($borrower->employment_status) }}</p>
      </div>
    </div>

    <div class="mt-6" x-data="{ open: false }">
      <h2 class="text-lg font-semibold mb-2">Uploaded ID Image</h2>

      @if ($borrower->id_image)
      <!-- Thumbnail Image -->
      <img @click="open = true" src="{{ asset($borrower->id_image) }}" alt="ID Image"
      class="w-56 h-auto rounded shadow cursor-pointer hover:scale-105 transition-transform duration-200">

      <!-- Fullscreen Modal -->
      <div x-show="open" x-transition @click.away="open = false"
      class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
      <img :src="'{{ asset($borrower->id_image) }}'" class="max-w-full max-h-full rounded shadow-lg"
      @click="open = false">
      </div>
    @else
      <p class="text-gray-500">No ID image uploaded.</p>
    @endif
    </div>
    </div>

    <div class="mt-6">
    <a href="{{ route('admin.borrowers.index') }}" class="text-blue-600 hover:underline text-sm">← Back to list</a>
    </div>
  </div>
@endsection
