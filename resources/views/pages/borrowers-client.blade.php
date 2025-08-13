@extends('layouts.app')

@section('title', 'ABG Finance - Borrowers')

@section('content')
  @auth
    <section class="bg-blue-600 text-white py-20">
    <div class="container mx-auto px-6 text-center">
    <h1 class="text-4xl font-bold mb-4">Borrowers Page</h1>
    <p class="text-lg mb-6">Some subtitle short description</p>
    </div>
    </section>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-bold">Borrowers List</h2>
    <p class="mb-4">View additional details of the borrower or create a new borrower below.</p>

    <x-borrower-form />

    @if($borrowers->count())
    <div class="space-y-4 mt-6">
    @foreach($borrowers as $borrower)
    <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between hover:shadow-lg transition">
      <div>
      <span class="text-gray-500">#{{ $borrower->id }}</span>
      <h2 class="text-xl font-bold">{{ $borrower->fname }} {{ $borrower->lname }}</h2>
      <p class="text-gray-600">Email Address: {{ $borrower->email }}</p>
      <p class="text-gray-600">Contact Number: {{ $borrower->contact_number }}</p>
      </div>
      {{-- @if($borrower->id_image)
      <img src="{{ asset($borrower->id_image) }}" alt="ID Image" class="w-16 h-16 object-cover rounded-full border">
      @endif --}}
      <a href="{{ route('showBorrower', $borrower->id) }}" class="text-blue-600 hover:underline">
      View
      </a>
    </div>
    @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
    {{ $borrowers->links() }}
    </div>
    @else
    <p class="mt-4 text-gray-500">No borrowers found.</p>
    @endif

    @endauth
  @endsection
