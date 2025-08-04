<div x-data="{ open: false }">
  <!-- Delete Button -->
  <button @click="open = true" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
    Delete
  </button>

  <!-- Modal -->
  <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div @click.outside="open = false" class="bg-white p-6 rounded shadow max-w-md w-full">
      <h2 class="text-lg font-bold mb-4">Delete Borrower</h2>
      <p class="mb-4 text-sm">Are you sure you want to delete <strong>{{ $borrower->fname }}
          {{ $borrower->lname }}</strong>?</p>

      <form method="POST" action="{{ route('admin.borrowers.destroy', $borrower->id) }}">
        @csrf
        @method('DELETE')

        <div class="flex justify-end space-x-2">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">
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
