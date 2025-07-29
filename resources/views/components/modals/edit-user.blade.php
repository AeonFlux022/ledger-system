<div x-data="{ open: false }" x-init="
  @if ($errors->get('edit_' . $user->id))
  open = true
  @endif
" class="inline">
  <!-- Trigger Button -->
  <button @click="open = true"
    class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
    Edit
  </button>


  <!-- Modal -->
  <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
    <div @click.outside="open = false" class="bg-white w-full max-w-md p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">Edit User</h2>

      <!-- Validation -->
      @if ($errors->get('edit_' . $user->id))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <ul class="mt-2 list-disc list-inside text-sm">
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
          <select name="role" class=" " required>
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
              Admin
            </option>
            <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>
              Super Admin
            </option>
          </select>
        </div>


        <div class="flex justify-end space-x-2">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
