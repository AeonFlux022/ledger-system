

<?php $__env->startSection('content'); ?>
  <h2 class="text-2xl font-bold mb-4">Payments</h2>

  

  <?php if($payments->count()): ?>
    <table class="w-full mt-4 border-collapse border">
      <thead class="text-left bg-gray-100">
        <tr>
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2">Payment ID</th>
          <th class="border px-4 py-2">Reference ID</th>
          <th class="border px-4 py-2">Month</th>
          <th class="border px-4 py-2">Amount</th>
          <th class="border px-4 py-2">Date</th>

        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2"></td>
            <td class="border px-4 py-2"><?php echo e($payments->id); ?></td>
            <td class="border px-4 py-2"><?php echo e($payments->reference_id); ?></td>
            <td class="border px-4 py-2"><?php echo e($payments->month); ?></td>
            <td class="border px-4 py-2"><?php echo e(number_format($payments->amount, 2)); ?></td>
            <td class="border px-4 py-2"><?php echo e($payments->created_at); ?></td>

          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="mt-4 text-gray-500">No payments found.</p>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\admin\payments\index.blade.php ENDPATH**/ ?>