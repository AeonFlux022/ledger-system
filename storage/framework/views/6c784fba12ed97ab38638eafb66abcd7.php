

<?php $__env->startSection('title', 'Borrower Details'); ?>

<?php $__env->startSection('content'); ?>
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Borrower Details</h1>

    <div class="bg-white shadow-md rounded p-6 space-y-4">
    <div class="grid grid-cols-2 gap-4">
      <div><strong>First Name:</strong> <?php echo e($borrower->fname); ?></div>
      <div><strong>Last Name:</strong> <?php echo e($borrower->lname); ?></div>
      <div><strong>Address:</strong> <?php echo e($borrower->address); ?></div>
      <div><strong>Contact Number:</strong> <?php echo e($borrower->contact_number); ?></div>
      <div><strong>Email:</strong> <?php echo e($borrower->email); ?></div>
      <div><strong>ID Type:</strong> <?php echo e(ucwords(str_replace('_', ' ', $borrower->id_card))); ?></div>
      <div><strong>Income:</strong> ₱<?php echo e(number_format($borrower->income, 2)); ?></div>
      <div><strong>Employment Status:</strong> <?php echo e(ucfirst($borrower->employment_status)); ?></div>
    </div>

    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">Uploaded ID Image</h2>
      <?php if($borrower->id_image): ?>
      <img src="<?php echo e(asset($borrower->id_image)); ?>" alt="ID Image" class="w-full rounded shadow">
    <?php else: ?>
      <p class="text-gray-500">No ID image uploaded.</p>
    <?php endif; ?>
    </div>
    </div>

    <div class="mt-6">
    <a href="<?php echo e(route('admin.borrowers.index')); ?>" class="text-blue-600 hover:underline">← Back to list</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/show.blade.php ENDPATH**/ ?>