@props(['loan', 'payment'])

@php
  $dueDate = \Carbon\Carbon::parse($payment['due_date']);
  $paid = $loan->payments->firstWhere('month', $payment['month']);
  $penalty = 0;

  if (!$paid && now()->greaterThan($dueDate)) {
    $penalty = $payment['amount'] * 0.03; // 1% penalty
  }

  $totalPayable = $payment['amount'] + $penalty;
@endphp

<div x-data="{ open: false }" class="inline-block">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
    Add Payment
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      x-transition>
      <div @click.outside="open = false" class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">

        <h2 class="text-xl font-bold mb-4">
          Add Payment for Loan #{{ $loan->id }}
        </h2>

        <form method="POST" action="{{ route('admin.loans.payments.store', $loan->id) }}" class="space-y-4">
          @csrf

          <!-- Hidden month -->
          <input type="hidden" name="month" value="{{ $payment['month'] }}">

          <!-- Hidden due date -->
          <input type="hidden" name="due_date" value="{{ $payment['due_date'] }}">

          <input type="hidden" name="penalty" value="{{ $penalty }}">


          <div>
            <label class="block mb-1 font-medium">Due Date</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($payment['due_date'])->format('F j, Y') }}"
              class="w-full border px-4 py-2 rounded  bg-gray-100 cursor-not-allowed" readonly>
          </div>

          <div>
            <label class="block mb-1 font-medium">Base Amount</label>
            <input type="text" name="amount" value="{{ $payment['amount']  }}" step="0.01"
              class="w-full border px-4 py-2 rounded  cursor-not-allowed bg-gray-100" readonly>
          </div>

          <div>
            <label class="block mb-1 font-medium">Penalty</label>
            <input type="text" value="₱{{ number_format($penalty, 2) }}"
              class="w-full border px-4 py-2 rounded cursor-not-allowed bg-gray-100" readonly>
          </div>

          <div>
            <label class="block mb-1 font-medium">Total Payable</label>
            <input type="text" value="₱{{ number_format($totalPayable, 2) }}"
              class="w-full border px-4 py-2 rounded cursor-not-allowed mb-5 bg-gray-100" readonly>
          </div>


          <div class="flex justify-end space-x-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">
              Cancel
            </button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              Save Payment
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>
