@extends('layouts.guest')

@section('content')
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow p-8 text-center">

      <h1 class="text-4xl font-bold text-red-600 mb-4">
        403
      </h1>

      <h2 class="text-xl font-semibold text-gray-800 mb-2">
        Unauthorized Access
      </h2>

      <p class="text-gray-600 mb-6">
        You do not have permission to access this page.
        Please contact the system administrator if you believe this is an error.
      </p>

      <a href="{{ route('dashboard') }}"
        class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
        Go Back
      </a>

    </div>
  </div>
@endsection
