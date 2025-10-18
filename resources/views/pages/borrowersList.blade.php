@extends('layouts.app')

@section('title', 'ABG Finance - Borrowers')

@section('content')
  @auth
    <div class="overflow-hidden mt-6 mx-6 rounded-lg border-gray-200 ">
    <div class="flex flex-row md:flex-col space-y-4 ">
    <div class="w-full p-6 rounded bg-blue-100">
      <div class="flex justify-between items-center">
      <div class="space-y-2">
      <h2 class="text-2xl font-bold">Borrowers List</h2>
      <p class="">You can view additional details of the borrower or create a new one.</p>
      </div>
      <div>
      <x-borrower-form />
      </div>
      </div>
    </div>

    <div class="w-full bg-white rounded p-6">
      <div class="mb-6">
      <input type="text" id="search" placeholder="Search for a borrower"
      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
      </div>

      <div id="borrower-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($borrowers as $borrower)
      <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-bold">{{ $borrower->fname }} {{ $borrower->lname }}</h2>
      <p class="text-gray-600">Email: {{ $borrower->email }}</p>
      <p class="text-gray-600">Contact: {{ $borrower->contact_number }}</p>
      <a href="{{ route('showBorrower', $borrower->id) }}"
      class="block mt-4 px-4 py-2 bg-blue-600 text-white rounded text-center hover:bg-blue-700">View</a>
      </div>
    @endforeach
      </div>


      {{-- ID Image (Optional) --}}
      {{--
      @if($borrower->id_image)
      <div class="mt-4">
      <img src="{{ asset($borrower->id_image) }}" alt="ID Image" class="w-full h-32 object-cover rounded-md border">
      </div>
      @endif
      --}}


      <!-- Pagination -->
      <div class="mt-6">
      {{ $borrowers->appends(['search' => request('search')])->links() }}
      </div>
    @else
      <p class="mt-4 text-gray-500">No borrowers found.</p>
    @endauth
    </div>

@endsection
