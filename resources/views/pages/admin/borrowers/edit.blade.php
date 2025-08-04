@extends('layouts.admin')

@section('title', 'ABG Finance')

@section('content')
  <div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Borrower</h1>
    {{-- @dd($borrower) --}}
    <x-borrower-form :borrower="$borrower" />

  </div>
@endsection
