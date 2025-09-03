@props(['loan', 'payment'])

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

          <div>
            <label class="block mb-1 font-medium">Amount</label>
            <input type="number" name="amount" value="{{ $payment['amount'] }}" step="0.01"
              class="w-full border px-4 py-2 rounded mb-3" required>
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
