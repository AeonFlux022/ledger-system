

<?php $__env->startSection('content'); ?>
  <h2 class="text-2xl font-bold mb-4">Transactions</h2>

  

  <?php if($transactions->count()): ?>
    <table class="w-full mt-4 border-collapse border">
      <thead class="text-left bg-gray-100">
        <tr>
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2">Transaction ID</th>
          <th class="border px-4 py-2">Amount</th>
          <th class="border px-4 py-2">Date</th>
          <th class="border px-4 py-2">Reference ID</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2"></td>
            <td class="border px-4 py-2"><?php echo e($transaction->id); ?></td>
            <td class="border px-4 py-2"><?php echo e(number_format($transaction->amount, 2)); ?></td>
            <td class="border px-4 py-2"><?php echo e($transaction->created_at); ?></td>
            <td class="border px-4 py-2"><?php echo e($transaction->reference_id); ?></td>

          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="mt-4 text-gray-500">No transactions found.</p>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/transactions/index.blade.php ENDPATH**/ ?>