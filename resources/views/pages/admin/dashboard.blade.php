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
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M15 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>

      <!-- Borrowers -->
      <div class="bg-indigo-50 p-5 rounded-xl shadow flex items-center justify-between h-full">
        <div>
          <h2 class="text-indigo-600 text-sm mb-2">Borrowers</h2>
          <p class="text-3xl font-bold text-indigo-700">{{ $borrowerCount }}</p>
        </div>
        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>

      <!-- Loans -->
      <div class="bg-blue-50 p-5 rounded-xl shadow flex items-center justify-between">
        <div>
          <h2 class="text-blue-600 text-sm mb-2">Loans</h2>
          <p class="text-3xl font-bold text-blue-700">{{ $loanCount }}</p>
        </div>
        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3v1h6v-1c0-1.657-1.343-3-3-3z" />
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
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
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
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-14v14" />
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
  <!-- Manual Loan Reminder Trigger -->
  <div class="mt-10" x-data="{ open: false }">
    <div class="bg-white p-6 rounded-xl shadow flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

      <div>
        <h2 class="text-lg font-bold text-gray-800">
          Loan Reminder Notifications
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Manually send SMS reminders to borrowers whose loans are due within 3 days,
          on the due date, or overdue by 1 day.
        </p>
      </div>

      <form method="POST" action="{{ route('admin.loans.send-reminders') }}" onsubmit="return confirm('Send loan reminders now? This will notify eligible borrowers via SMS.')">
        @csrf
        <button type="button" @click="open = true" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold
                  hover:bg-blue-700 transition shadow">

          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18" />
          </svg>

          Trigger Loan Reminders
        </button>
      </form>

    </div>

    <!-- Modal Backdrop -->
    <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 bg-black/50 z-40" @click="open = false">
    </div>

    <!-- Modal -->
    <div x-show="open" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4" @keydown.escape.window="open = false">

      <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.stop>

        <h3 class="text-lg font-bold text-gray-800 mb-2">
          Send Loan Reminders
        </h3>

        <p class="text-sm text-gray-600 mb-4">
          This will send SMS reminders to eligible borrowers.
          Are you sure you want to proceed?
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('admin.loans.send-reminders') }}">
          @csrf

          <!-- Optional FORCE checkbox -->
          <label class="flex items-center mb-4 space-x-2">
            <input type="checkbox" name="force" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">

            <span class="text-sm text-gray-700">
              Force send reminders (ignore due date range)
            </span>
          </label>

          <div class="flex justify-end gap-3">
            <button type="button" @click="open = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
              Cancel
            </button>

            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold
                 hover:bg-blue-700 transition">
              Send Now
            </button>
          </div>
        </form>

      </div>
    </div>

  </div>

</div>
@endsection
