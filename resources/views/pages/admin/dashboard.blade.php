@extends('layouts.admin') {{-- Assuming you have a base layout --}}

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Admin Dashboard</h1>

    <div class="text-sm mb-6 text-gray-600">
      <span id="ph-time" class="font-semibold"></span>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Users -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Users</h2>
        <p class="text-3xl font-bold mt-2">{{ $userCount }}</p>
      </div>

      <!-- Borrowers -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Borrowers</h2>
        <p class="text-3xl font-bold mt-2">{{ $borrowerCount }}</p>
      </div>

      <!-- Total Loans -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Loans</h2>
        <p class="text-3xl font-bold mt-2">{{ $loanCount }}</p>
      </div>

      <!-- Approved Loans -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Approved Loans</h2>
        <p class="text-3xl font-bold mt-2 ">{{ $approvedLoans }}</p>
        {{-- <p class="text-xs text-gray-400">Coming soon</p> --}}
      </div>

      <!-- Total Loan Amount -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Total Loan Amount</h2>
        <p class="text-3xl font-bold mt-2">
          ₱{{ number_format($totalLoanAmount, 2) }}
        </p>
      </div>

      <!-- Total Income -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-gray-500 text-sm mb-5">Total Loan Income</h2>
        <p class="text-3xl font-bold mt-2">₱{{ number_format($totalEarnings, 2) }}</p>
        {{-- <p class="text-xs text-gray-400">Coming soon</p> --}}
      </div>
    </div>
  </div>
@endsection
