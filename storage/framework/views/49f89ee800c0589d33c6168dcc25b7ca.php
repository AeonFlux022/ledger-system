<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $borrower)): ?>
  <div x-data="{ open: false }" x-cloak>
    <!-- Delete Button -->
    <button @click="open = true" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
      Delete
    </button>

    <!-- Modal -->
    <template x-teleport="body">+
      <div x-show="open" x-transition x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.outside="open = false" class="bg-white p-6 rounded shadow max-w-md w-full">
          <h2 class="text-lg font-bold mb-4">Delete Borrower</h2>
          <p class="mb-4 text-sm">
            Are you sure you want to delete
            <strong><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></strong>?
          </p>

          <form method="POST" action="<?php echo e(route('admin.borrowers.destroy', $borrower->id)); ?>">
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
    </template>
  </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/delete-borrower.blade.php ENDPATH**/ ?>