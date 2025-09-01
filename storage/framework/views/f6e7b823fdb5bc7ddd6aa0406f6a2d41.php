

<?php $__env->startSection('title', 'ABG Finance - Loan Schedule'); ?>

<?php $__env->startSection('content'); ?>
  <div class="overflow-hidden mt-6 mx-4 rounded-lg border-gray-200 ">
    <div class="flex flex-row md:flex-col space-y-4 ">
    <div class="w-full p-6 rounded bg-blue-100">
      <div class="flex justify-between items-center">
      <div class="space-y-2">
        <p class="text-gray-700 text-sm"><?php echo e($borrower->id); ?> </p>
        <h1 class="text-4xl font-bold"><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></h1>
        <h2>Amortization Schedule - ₱<?php echo e(number_format($loan->loan_amount, 2)); ?> </h2>

      </div>
      
      </div>

    </div>
    <div class="w-full p-6 bg-white rounded">
      <table class="w-full">
      <thead class="bg-gray-300 text-left">
        <tr>
        <th class="px-4 py-2">#</th>
        <th class="px-4 py-2">Due Date</th>
        <th class="px-4 py-2">Terms</th>
        <th class="px-4 py-2">Due Date</th>
        <th class="px-4 py-2">Total Payment</th>
        <th class="px-4 py-2">Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $paginatedSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="text-left border-b border-gray-200 hover:bg-gray-50">
      <td class="px-4 py-2"><?php echo e($loop->iteration); ?></td>
      <td class="px-4 py-2"><?php echo e($row['due_date']); ?></td>
      <td class="px-4 py-2"><?php echo e($row['month']); ?></td>
      <td class="px-4 py-2">₱<?php echo e(number_format($row['amount'], 2)); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
      </table>

      <div class="mt-4">
      <?php echo e($paginatedSchedule->links()); ?>

      </div>

      <div class="mt-6">
      <a href="<?php echo e(route('loans.client', $borrower->id)); ?>" class="text-blue-600 hover:underline text-sm">
        ← Back to Loans
      </a>

      </div>
    </div>
    </div>

  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\showSchedule.blade.php ENDPATH**/ ?>