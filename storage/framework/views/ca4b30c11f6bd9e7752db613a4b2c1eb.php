<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title', ''); ?></title>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-gray-100 text-gray-900">
  <div class="container mx-auto">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="mx-auto">
      <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="mt-8 text-center text-sm text-gray-600">
      &copy; <?php echo e(date('Y')); ?> E-Ledger for Moneylenders. All rights reserved.
    </footer>
  </div>
</body>

</html>

<script src="//unpkg.com/alpinejs" defer></script>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>