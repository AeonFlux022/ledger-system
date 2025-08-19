<nav class="bg-white shadow-md">
  <div class="container mx-auto px-6 py-4 flex justify-between items-center">
    <a href="/" class="text-xl font-bold text-blue-600">ABG Finance</a>

    <ul class="flex space-x-4 items-center">
      <li><a href="/" class="text-gray-700 hover:text-blue-600">Home</a></li>


      
      <?php if(auth()->guard()->guest()): ?>
      
      <li><a href="/about" class="text-gray-700 hover:text-blue-600">About Us</a></li>
      <li><a href="/service" class="text-gray-700 hover:text-blue-600">Services</a></li>
      <li><a href="/contact" class="text-gray-700 hover:text-blue-600">Contact</a></li>
      <li><a href="<?php echo e(route('login')); ?>" class="text-red-500 hover:underline">Login</a></li>
    <?php endif; ?>

      
      <?php if(auth()->guard()->check()): ?>
      <li><a href="/borrowers" class="text-gray-700 hover:text-blue-600">Borrowers</a></li>
      <li><a href="/loans-list" class="text-gray-700 hover:text-blue-600">Loans</a></li>
      <li><a href="/transactions-list" class="text-gray-700 hover:text-blue-600">Transactions</a></li>
      <li class="text-gray-700">Hello, <span class="font-semibold"><?php echo e(auth()->user()->username); ?></span></li>

      <li>
      <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="text-red-500 hover:underline">Logout</button>
      </form>
      </li>
    <?php endif; ?>
    </ul>
  </div>
</nav>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/navbar.blade.php ENDPATH**/ ?>