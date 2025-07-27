@extends('layouts.admin')

@section('title', 'Borrowers')

@section('content')
  @auth
    <h1 class="text-2xl font-bold mb-4">Welcome to Borrowers</h1>
    <p>Hello, {{ auth()->user()->username }}</p>
  @endauth
@endsection
