

<?php $__env->startSection('content'); ?>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Payments</h1>

    <?php if($payments->count()): ?>
      <table class="w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Loan ID</th>
            <th class="px-4 py-2">Borrower</th>
            <th class="px-4 py-2">Reference ID</th>
            <th class="px-4 py-2">Month</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo e($index + 1); ?></td>
              <td class="px-4 py-2"><?php echo e($payment->loan->id); ?></td>
              <td class="px-4 py-2">
                <?php echo e($payment->loan->borrower->fname); ?> <?php echo e($payment->loan->borrower->lname); ?>

              </td>
              <td class="px-4 py-2 font-mono"><?php echo e($payment->reference_id); ?></td>
              <td class="px-4 py-2"><?php echo e($payment->month); ?></td>
              <td class="px-4 py-2">₱<?php echo e(number_format($payment->amount, 2)); ?></td>
              <td class="px-4 py-2"><?php echo e($payment->created_at->format('M d, Y')); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>

      <div class="mt-4">
        <?php echo e($payments->links()); ?>

      </div>
    <?php else: ?>
      <p class="mt-4 text-gray-500">No payments found.</p>
    <?php endif; ?>

  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/payments/index.blade.php ENDPATH**/ ?>