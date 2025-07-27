@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  @auth
    <h1 class="text-2xl font-bold mb-4">Welcome to Admin Dashboard</h1>
    <p>Hello, {{ auth()->user()->username }}</p>
  @endauth
@endsection
