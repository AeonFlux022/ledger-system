 

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-6">Borrowers</h1>

    <div class="mb-6">
    <a href="<?php echo e(route('admin.borrowers.create')); ?>"
      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
      + Add Borrower
    </a>
    </div>

    <table class="w-full bg-white shadow-md rounded border">
    <thead class="bg-gray-100 text-left">
      <tr>
      <th class="px-4 py-2">#</th>
      <th class="px-4 py-2">Name</th>
      <th class="px-4 py-2">Contact</th>
      <th class="px-4 py-2">Email</th>
      <th class="px-4 py-2">Employment</th>
      <th class="px-4 py-2">Status</th>
      <th class="px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr class="border-t">
      <td class="px-4 py-2"><?php echo e($loop->iteration); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->contact_number); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->email); ?></td>
      <td class="px-4 py-2"><?php echo e(ucfirst($borrower->employment_status)); ?></td>
      <td class="px-4 py-2"><?php echo e(ucfirst($borrower->status)); ?></td>
      <td class="px-4 py-2">
      <a href="<?php echo e(route('admin.borrowers.show', $borrower->id)); ?>" class="text-blue-600 hover:underline">View</a>

      
      </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
      <td colspan="5" class="px-4 py-4 text-center text-gray-500">No borrowers found.</td>
      </tr>
    <?php endif; ?>
    </tbody>
    </table>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/index.blade.php ENDPATH**/ ?>