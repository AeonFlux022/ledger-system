 

<?php $__env->startSection('content'); ?>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Admin Dashboard</h1>

    <div class="text-sm mb-6 text-gray-600">
    <span id="ph-time" class="font-semibold"></span>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Users -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Users</h2>
      <p class="text-3xl font-bold mt-2"><?php echo e($userCount); ?></p>
    </div>

    <!-- Borrowers -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Borrowers</h2>
      <p class="text-3xl font-bold mt-2"><?php echo e($borrowerCount); ?></p>
    </div>

    <!-- Total Loans -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Loans</h2>
      <p class="text-3xl font-bold mt-2"><?php echo e($loanCount); ?></p>
    </div>

    <!-- Total Loan Amount -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Total Loan Amount</h2>
      <p class="text-3xl font-bold mt-2">
      ₱<?php echo e(number_format($totalLoanAmount, 2)); ?>

      </p>
    </div>



    <!-- Approved Loans -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Approved Loans</h2>
      <p class="text-3xl font-bold mt-2 "><?php echo e($approvedLoans); ?></p>
      
    </div>

    <!-- Total Income -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-gray-500 text-sm">Total Loan Income</h2>
      <p class="text-3xl font-bold mt-2 text-gray-400">₱<?php echo e(number_format($totalIncome, 2)); ?></p>
      <p class="text-xs text-gray-400">Coming soon</p>
    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\admin\dashboard.blade.php ENDPATH**/ ?>