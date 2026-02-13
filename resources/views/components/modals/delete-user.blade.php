@can('delete', $user)
  <div x-data="{ open: false }" x-key="delete-user-{{ $user->id }}" class="inline">
    <!-- Trigger -->
    <button type="button" @click="open = true"
      class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
      Delete
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open" x-cloak x-transition.opacity
      class="fixed inset-0 bg-black/50 flex items-start justify-center py-24 z-50">
      <!-- Modal Card -->
      <div @click.outside="open = false" x-transition.scale
        class="bg-white w-full max-w-sm max-h-[90vh] overflow-y-auto p-6 rounded shadow-lg">
        <h2 class="text-lg font-bold mb-4 text-red-600">Confirm Delete</h2>

        <p class="mb-2">
          Are you sure you want to delete user
          <strong>{{ $user->username }}</strong>?
        </p>
        <p class="text-sm text-gray-600 mb-4">
          This action cannot be undone.
        </p>

        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
          @csrf
          @method('DELETE')

          <div class="flex justify-end gap-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded hover:bg-gray-100"u>
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
@endcan
