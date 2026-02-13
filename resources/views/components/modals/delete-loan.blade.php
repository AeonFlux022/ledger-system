<div x-data="{ open: false }" x-key="delete-loan-{{ $loan->id }}" class="inline">
  <!-- Trigger -->
  <button type="button" @click="open = true" class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">
    Delete
  </button>

  <!-- Modal Backdrop -->
  <div x-show="open" x-cloak x-transition.opacity
    class="fixed inset-0 bg-black/50 flex items-start justify-center py-24 z-50">
    <!-- Modal Card -->
    <div @click.outside="open = false" x-transition.scale
      class="bg-white w-full max-w-md max-h-[90vh] overflow-y-auto p-6 rounded shadow-lg">
      <h2 class="text-lg font-bold mb-2 text-red-600">
        Delete Loan
      </h2>

      <p class="mb-4 text-sm text-gray-700">
        This will permanently delete the loan and
        <strong class="text-red-600">all associated payments</strong>.
        This action cannot be undone.
      </p>

      <form method="POST" action="{{ route('admin.loans.destroy', $loan->id) }}">
        @csrf
        @method('DELETE')

        <div class="flex justify-end gap-2">
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
</div>
