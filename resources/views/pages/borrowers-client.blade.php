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
    <h2 class="text-2xl font-bold">Fill out the information of the borrower to continue.</h2>
    <p class="mb-4">Here you can manage your borrowers.</p>

    <x-borrower-form />

    </div>
  @endauth
@endsection
