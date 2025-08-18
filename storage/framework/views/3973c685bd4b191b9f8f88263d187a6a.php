

<?php $__env->startSection('title', 'ABG Finance - Loan Details'); ?>

<?php $__env->startSection('content'); ?>
  <div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-2">Loan Details</h1>
    <p class="text-sm text-gray-500 mb-6">
    Submitted at <?php echo e($loan->created_at->format('F j, Y g:i A')); ?>

    </p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 space-y-8">
    <!-- Borrower Info -->
    <div class="mb-6">
      <h3 class="font-bold">Borrower</h3>
      <p><?php echo e($loan->borrower->fname); ?> <?php echo e($loan->borrower->lname); ?></p>
    </div>
    <hr>

    <!-- Loan Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
      <div>
      <label class="text-sm text-gray-500">Loan Amount</label>
      <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->loan_amount, 2)); ?></p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Interest Rate</label>
      <p class="mt-1 font-medium"><?php echo e($loan->interest_rate); ?>% per month</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Terms</label>
      <p class="mt-1 font-medium"><?php echo e($loan->terms); ?> months</p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Processing Fee</label>
      <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->processing_fee, 2)); ?></p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Total Payable</label>
      <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->total_payable, 2)); ?></p>
      </div>
      <div>
      <label class="text-sm text-gray-500">Monthly Amortization</label>
      <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->monthly_amortization, 2)); ?></p>
      </div>
    </div>

    <!-- Amortization Table -->
    <h3 class="font-semibold mb-2">Amortization Schedule</h3>
    <table class="w-full">
      <thead class="bg-gray-100">
      <tr>
        <th class="px-3 py-2">Month</th>
        <th class="px-3 py-2">Due Date</th>
        <th class="px-3 py-2">Amount</th>
      </tr>
      </thead>
      <tbody>
      <?php $__currentLoopData = $paginatedSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="border-b border-gray-200 hover:bg-gray-50">
      <td class="px-3 py-2 text-center"><?php echo e($payment['month']); ?></td>
      <td class="px-3 py-2 text-center"><?php echo e($payment['due_date']); ?></td>
      <td class="px-3 py-2 text-right">₱<?php echo e(number_format($payment['amount'], 2)); ?></td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <div class="mt-4">
      <?php echo e($paginatedSchedule->links()); ?>

    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-2 mt-6">
      <form method="POST" action="">
      <?php echo csrf_field(); ?>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Approve
      </button>
      </form>
      <form method="POST" action="">
      <?php echo csrf_field(); ?>
      <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Decline
      </button>
      </form>
    </div>
    </div>

    <div class="mt-6">
    <a href="<?php echo e(route('admin.loans.index')); ?>" class="text-blue-600 hover:underline text-sm">← Back to list</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/loans/show.blade.php ENDPATH**/ ?>