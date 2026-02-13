<div x-data="{ open: false }" x-key="user-{{ $user->id }}" x-init="
        @if ($errors->get('edit_' . $user->id))
          open = true
        @endif
    " class="inline">
  <!-- Trigger -->
  <button type="button" @click="open = true"
    class="px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
    Edit
  </button>

  <!-- Modal Backdrop -->
  <div x-show="open" x-cloak x-transition.opacity
    class="fixed inset-0 bg-black/50 flex items-start justify-center py-16 z-50">
    <!-- Modal Card -->
    <div @click.outside="open = false" x-transition.scale
      class="bg-white w-full max-w-md max-h-[90vh] overflow-y-auto p-6 rounded shadow-lg">
      <h2 class="text-lg font-bold mb-4">Edit User</h2>

      <!-- Validation -->
      @if ($errors->get('edit_' . $user->id))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->get('edit_' . $user->id) as $message)
              <li>{{ $message }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Edit Form -->
      <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="block mb-1">Username</label>
          <input name="username" value="{{ old('username', $user->username) }}" required
            class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required
            class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Role</label>
          <select name="role" class="w-full border px-3 py-2 rounded" required>
            <option value="admin" @selected(old('role', $user->role) === 'admin')>
              Admin
            </option>
            <option value="super_admin" @selected(old('role', $user->role) === 'super_admin')>
              Super Admin
            </option>
          </select>
        </div>

        <div class="flex justify-end gap-2 mt-6">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">
            Cancel
          </button>

          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
