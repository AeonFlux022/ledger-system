@extends('layouts.app')

@section('title', 'Borrower Details')

@section('content')
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Borrower Details</h1>

    <div class="bg-white shadow-md rounded p-6 space-y-4">
    <div class="grid grid-cols-2 gap-4">
      <div><strong>First Name:</strong> {{ $borrower->fname }}</div>
      <div><strong>Last Name:</strong> {{ $borrower->lname }}</div>
      <div><strong>Address:</strong> {{ $borrower->address }}</div>
      <div><strong>Contact Number:</strong> {{ $borrower->contact_number }}</div>
      <div><strong>Email:</strong> {{ $borrower->email }}</div>
      <div><strong>ID Type:</strong> {{ ucwords(str_replace('_', ' ', $borrower->id_card)) }}</div>
      <div><strong>Income:</strong> ₱{{ number_format($borrower->income, 2) }}</div>
      <div><strong>Employment Status:</strong> {{ ucfirst($borrower->employment_status) }}</div>
    </div>

    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">Uploaded ID Image</h2>
      @if ($borrower->id_image)
      <img src="{{ asset($borrower->id_image) }}" alt="ID Image" class="w-full rounded shadow">
    @else
      <p class="text-gray-500">No ID image uploaded.</p>
    @endif
    </div>
    </div>

    <div class="mt-6">
    <a href="{{ route('admin.borrowers.index') }}" class="text-blue-600 hover:underline">← Back to list</a>
    </div>
  </div>
@endsection
