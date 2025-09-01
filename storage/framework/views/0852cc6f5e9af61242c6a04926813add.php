<div x-data="{ open: false }" x-init="
  <?php if($errors->get('edit_' . $user->id)): ?>
    open = true
  <?php endif; ?>
" class="inline">
  <!-- Trigger Button -->
  <button @click="open = true"
    class="px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
    Edit
  </button>


  <!-- Modal -->
  <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
    x-cloak>
    <div @click.outside="open = false" class="bg-white w-full max-w-md p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">Edit User</h2>

      <!-- Validation -->
      <?php if($errors->get('edit_' . $user->id)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="mt-2 list-disc list-inside text-sm">
            <?php $__currentLoopData = $errors->get('edit_' . $user->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($message); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Edit Form -->
      <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
          <label class="block mb-1">Username</label>
          <input name="username" value="<?php echo e(old('username', $user->username)); ?>" required
            class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Email</label>
          <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
            class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-3">
          <label class="block mb-1">Role</label>
          <select name="role" class="w-full border px-3 py-2 rounded" required>
            <option value="admin" <?php echo e(old('role', $user->role) === 'admin' ? 'selected' : ''); ?>>
              Admin
            </option>
            <option value="super_admin" <?php echo e(old('role', $user->role) === 'super_admin' ? 'selected' : ''); ?>>
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
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/edit-user.blade.php ENDPATH**/ ?>