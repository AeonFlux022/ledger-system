<div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
  <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login to Your Account</h2>

  
  <?php if($errors->any()): ?>
    <div class="mb-4 text-sm text-red-600 bg-red-100 border border-red-300 rounded p-3">
    <ul class="list-disc pl-5 space-y-1">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo e($error); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5 mb-4">
    <?php echo csrf_field(); ?>

    <div>
      <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
      <input id="username" name="username" type="text" value="<?php echo e(old('username')); ?>" required autofocus
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input id="password" name="password" type="password" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
    </div>

    <div class="flex items-center">
      <input type="checkbox" name="remember" id="remember"
        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
      <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
    </div>

    <div>
      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow">
        Login
      </button>
    </div>
  </form>

  
  
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/forms/auth/login.blade.php ENDPATH**/ ?>