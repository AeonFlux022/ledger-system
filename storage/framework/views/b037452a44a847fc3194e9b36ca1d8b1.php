

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
  <?php if(auth()->guard()->check()): ?>
    <h1 class="text-2xl font-bold mb-4">Welcome to Admin Dashboard</h1>
    <p>Hello, <?php echo e(auth()->user()->username); ?></p>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/dashboard.blade.php ENDPATH**/ ?>