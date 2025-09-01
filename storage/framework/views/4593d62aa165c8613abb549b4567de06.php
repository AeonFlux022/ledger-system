<div x-data="{ open: false }">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
    + Add User
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
      x-cloak>
      <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Create New User</h2>

        <form method="POST" action="<?php echo e(route('admin.users.store')); ?>" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>

          <div class="grid grid-cols-1 gap-4">
            <div>
              <label class="block mb-1">Username</label>
              <input name="username" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Email</label>
              <input name="email" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Role</label>
              <select name="role" class="w-full border px-3 py-2 rounded" required>
                <option value="" default>Select Role</option>
                <option value="admin">Loan Officer</option>
                <option value="super_admin">Admin</option>
              </select>
            </div>

            <div>
              <label class="block mb-1">Password</label>
              <input type="password" name="password" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Confirm Password</label>
              <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div class="flex justify-end space-x-2 mt-6">
              <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
              </button>
            </div>
        </form>
      </div>
    </div>
  </template>
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\components\modals\create-user.blade.php ENDPATH**/ ?>