<div x-data="{ open: false }">
  <!-- Decline Button -->
  <button @click="open = true" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
    Decline
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

      <div @click.outside="open = false" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

        <h2 class="text-lg font-bold mb-3">Decline Loan Application</h2>

        <p class="text-sm text-gray-600 mb-4">
          Please provide a reason for declining this loan.
        </p>

        <form method="POST" action="{{ route('admin.loans.decline', $loan->id) }}">
          @csrf

          <textarea name="reason" required rows="4"
            class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-red-200"
            placeholder="e.g. Insufficient income, incomplete documents, failed verification..."></textarea>

          <div class="flex justify-end mt-4 space-x-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">
              Cancel
            </button>

            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
              Confirm Decline
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>
