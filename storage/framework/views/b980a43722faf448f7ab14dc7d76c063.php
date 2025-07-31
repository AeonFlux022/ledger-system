<div x-data="{ open: false }" class="inline">
  <!-- Trigger Button -->
  <button @click="open = true" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
    Delete
  </button>


  <!-- Modal -->
  <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
    <div @click.outside="open = false" class="bg-white w-full max-w-sm p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4 text-red-600">Confirm Delete</h2>
      <p class="mb-4">Are you sure you want to delete user <strong><?php echo e($user->username); ?></strong>?</p>

      <form method="POST" action="<?php echo e(route('admin.users.destroy', $user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>

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
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/delete-user.blade.php ENDPATH**/ ?>