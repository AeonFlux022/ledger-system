@extends('layouts.admin')

@section('title', 'ABG Finance')

@section('content')
  <div class="px-4 py-10 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Borrower</h1>

    <x-borrower-form />

    <div class="mt-4">
    <a href="{{ route('admin.borrowers.index') }}" class="text-blue-600 hover:underline">← Back to Borrowers</a>
    </div>
  </div>
@endsection
