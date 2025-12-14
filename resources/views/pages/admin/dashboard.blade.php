@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Admin Dashboard</h1>

    <div class="text-sm mb-6 text-gray-600">
      <span id="ph-time" class="font-semibold"></span>
    </div>

    <div class="flex-1">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 h-full">

        <!-- Users -->
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between h-full">
          <div>
            <h2 class="text-gray-500 text-sm mb-2">Users</h2>
            <p class="text-3xl font-bold">{{ $userCount }}</p>
          </div>
          <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M15 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>

        <!-- Borrowers -->
        <div class="bg-indigo-50 p-5 rounded-xl shadow flex items-center justify-between h-full">
          <div>
            <h2 class="text-indigo-600 text-sm mb-2">Borrowers</h2>
            <p class="text-3xl font-bold text-indigo-700">{{ $borrowerCount }}</p>
          </div>
          <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>

        <!-- Loans -->
        <div class="bg-blue-50 p-5 rounded-xl shadow flex items-center justify-between">
          <div>
            <h2 class="text-blue-600 text-sm mb-2">Loans</h2>
            <p class="text-3xl font-bold text-blue-700">{{ $loanCount }}</p>
          </div>
          <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-1.657 0-3 1.343-3 3v1h6v-1c0-1.657-1.343-3-3-3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14v7H5z" />
          </svg>
        </div>

        <!-- Approved Loans -->
        <div class="bg-green-50 p-5 rounded-xl shadow flex items-center justify-between">
          <div>
            <h2 class="text-green-600 text-sm mb-2">Approved Loans</h2>
            <p class="text-3xl font-bold text-green-700">{{ $approvedLoans }}</p>
          </div>
          <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
          </svg>
        </div>

        <!-- Total Loan Amount -->
        <div class="bg-amber-50 p-5 rounded-xl shadow flex items-center justify-between">
          <div>
            <h2 class="text-amber-600 text-sm mb-2">Total Loan Amount</h2>
            <p class="text-3xl font-bold text-amber-700">
              ₱{{ number_format($totalLoanAmount, 2) }}
            </p>
          </div>
          <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-14v14" />
          </svg>
        </div>

        <!-- Total Income -->
        <div class="bg-emerald-50 p-5 rounded-xl shadow flex items-center justify-between">
          <div>
            <h2 class="text-emerald-600 text-sm mb-2">Total Loan Income</h2>
            <p class="text-3xl font-bold text-emerald-700">
              ₱{{ number_format($totalEarnings, 2) }}
            </p>
          </div>
          <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l4-4 3 3 5-5" />
          </svg>
        </div>

      </div>
    </div>

  </div>
@endsection
