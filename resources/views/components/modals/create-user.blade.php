<div x-data="{ open: false }" x-init="
  @if ($errors->any())
  open = true
  @endif
">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
    + Add User
  </button>

  <!-- Modal -->
  <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
    <div @click.outside="open = false" class="bg-white w-full max-w-md p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">Create New User</h2>

      @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <strong>Whoops!</strong> Please fix the following errors:
      <ul class="mt-2 list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
    @endif

      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
          <label class="block mb-1">Username</label>
          <input name="username" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Email</label>
          <input type="email" name="email" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Password</label>
          <input type="password" name="password" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Role</label>
          <select name="role" class="w-full border px-3 py-2 rounded">
            <option value="admin">Admin</option>
            <option value="super_admin">Super Admin</option>
          </select>
        </div>

        <div class="flex justify-end space-x-2">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
