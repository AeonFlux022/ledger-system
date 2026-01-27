@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Admin Dashboard</h1>

    <div class="text-sm mb-6 text-gray-600">
      <span id="ph-time" class="font-semibold"></span>
    </div>

    <div class="mb-10">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">
          System Overview
        </h2>
        <span class="text-xs text-gray-400">Live system statistics</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 h-full"></div>
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

          <!-- Rejected Loans -->
          <div class="bg-red-50 p-5 rounded-xl shadow flex items-center justify-between">
            <div>
              <h2 class="text-red-600 text-sm mb-2">Rejected Loans</h2>
              <p class="text-3xl font-bold text-red-700">{{ $rejectedLoans }}</p>
            </div>
            <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </div>
      </div>

      <div class="my-10 border-t border-gray-200"></div>


      <!-- FINANCIAL OVERVIEW CHART -->
      <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-4">
          Financial Overview
        </h2>

        <canvas id="financeChart" height="120"></canvas>

        @push('scripts')
          <script>
            document.addEventListener('DOMContentLoaded', function () {

              const ctx = document.getElementById('financeChart').getContext('2d');

              new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: ['Total Collected', 'Total Income'],
                  datasets: [
                    {
                      label: 'Previous Month',
                      data: [
                {{ $previousCollected }},
                        {{ $previousIncome }}
                      ],
                      borderWidth: 1
                    },
                    {
                      label: 'Current Month',
                      data: [
                {{ $currentCollected }},
                        {{ $currentIncome }}
                      ],
                      borderWidth: 1
                    }
                  ]
                },
                options: {
                  responsive: true,
                  plugins: {
                    legend: { position: 'bottom' }
                  },
                  scales: {
                    y: {
                      beginAtZero: true,
                      ticks: {
                        callback: function (value) {
                          return '₱' + value.toLocaleString();
                        }
                      }
                    }
                  }
                }
              });

            });
          </script>
        @endpush

      </div>


    </div>

    <div class="my-10 border-t border-gray-200"></div>

    <!-- TOP PERFORMERS -->
    <div class="mb-4">
      <h2 class="text-lg font-bold text-gray-800">
        Top Performers
      </h2>
      <p class="text-sm text-gray-500">
        Borrowers with the highest approved loans and payments
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-10">
      <div class="relative bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl shadow border border-green-100">

        <!-- Badge -->
        <span class="absolute -top-3 -left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
          TOP LOAN PATRONIZER
        </span>

        <div class="flex items-center gap-4">
          <!-- Avatar -->
          <div
            class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg">
            {{ strtoupper(substr($topLoanBorrower->fname ?? 'N', 0, 1)) }}
          </div>

          <div>
            <p class="text-sm text-gray-500">Highest Loaned (Approved)</p>
            @if($topLoanBorrower)
              <h2 class="text-lg font-bold text-gray-800">
                {{ $topLoanBorrower->fname }} {{ $topLoanBorrower->lname }}
              </h2>
              <p class="text-green-600 font-bold text-xl mt-1">
                &#x20B1;{{ number_format($topLoanBorrower->total_loaned, 2) }}
              </p>
            @else
              <p class="text-gray-400">No approved loans yet</p>
            @endif
          </div>
        </div>
      </div>


      <div class="relative bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow border border-blue-100">

        <!-- Badge -->
        <span class="absolute -top-3 -left-3 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
          TOP PAYING BORROWER
        </span>

        <div class="flex items-center gap-4">
          <!-- Avatar -->
          <div
            class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg">
            {{ strtoupper(substr($topPaymentBorrower->fname ?? 'N', 0, 1)) }}
          </div>

          <div>
            <p class="text-sm text-gray-500">Highest Paying (Approved)</p>
            @if($topPaymentBorrower)
              <h2 class="text-lg font-bold text-gray-800">
                {{ $topPaymentBorrower->fname }} {{ $topPaymentBorrower->lname }}
              </h2>
              <p class="text-blue-600 font-bold text-xl mt-1">
                &#x20B1;{{ number_format($topPaymentBorrower->total_paid, 2) }}
              </p>
            @else
              <p class="text-gray-400">No approved payments yet</p>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="my-10 border-t border-gray-200"></div>


    <!-- REMINDERS -->
    <div class="mb-4">
      <h2 class="text-lg font-bold text-gray-800">
        Loan Notifications
      </h2>
      <p class="text-sm text-gray-500">
        Send automated or manual SMS reminders to borrowers
      </p>
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
            on the due date, or overdue by 5 days.
          </p>
        </div>

        <form method="POST" action="{{ route('admin.loans.send-reminders') }}"
          onsubmit="return confirm('Send loan reminders now? This will notify eligible borrowers via SMS.')">
          @csrf
          <button type="button" @click="open = true"
            class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold
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
      <div x-show="open" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4"
        @keydown.escape.window="open = false">

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
              <input type="checkbox" name="force" value="1"
                class="rounded border-gray-300 text-red-600 focus:ring-red-500">

              <span class="text-sm text-gray-700">
                Force send reminders (ignore due date range)
              </span>
            </label>

            <div class="flex justify-end gap-3">
              <button type="button" @click="open = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                Cancel
              </button>

              <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold
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
