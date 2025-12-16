<div x-data="{ open: false }" x-cloak>
  <!-- Trigger Button -->
  <button @click="open = true" class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">
    Delete
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" x-transition.opacity
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

      <div x-transition.scale @click.outside="open = false" class="bg-white p-6 rounded shadow max-w-md w-full">

        <h2 class="text-lg font-bold mb-2 text-gray-800">
          Delete Loan
        </h2>

        <p class="mb-4 text-sm text-gray-700">
          This will permanently delete the loan and
          <strong>all associated payments</strong>.
          This action cannot be undone.
        </p>

        <form method="POST" action="{{ route('admin.loans.destroy', $loan->id) }}">
          @csrf
          @method('DELETE')

          <div class="flex justify-end space-x-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded hover:bg-gray-100">
              Cancel
            </button>

            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
              Delete
            </button>
          </div>
        </form>

      </div>
    </div>
  </template>
</div>
