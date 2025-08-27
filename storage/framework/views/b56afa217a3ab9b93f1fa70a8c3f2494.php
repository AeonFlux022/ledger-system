

<?php $__env->startSection('title', 'ABG Finance - Borrowers'); ?>

<?php $__env->startSection('content'); ?>
  <?php if(auth()->guard()->check()): ?>
    <div class="overflow-hidden mt-6 mx-6 rounded-lg border-gray-200 ">
    <div class="flex flex-row md:flex-col space-y-4 ">
    <div class="w-full p-6 rounded bg-blue-100">
      <div class="flex justify-between items-center">
      <div class="space-y-2">
      <h2 class="text-2xl font-bold">Borrowers List</h2>
      <p class="">You can view additional details of the borrower or create a new one.</p>
      </div>
      <div>
      <?php if (isset($component)) { $__componentOriginal7922fbef0b461d930310901d4bb23b63 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7922fbef0b461d930310901d4bb23b63 = $attributes; } ?>
<?php $component = App\View\Components\BorrowerForm::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('borrower-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\BorrowerForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7922fbef0b461d930310901d4bb23b63)): ?>
<?php $attributes = $__attributesOriginal7922fbef0b461d930310901d4bb23b63; ?>
<?php unset($__attributesOriginal7922fbef0b461d930310901d4bb23b63); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7922fbef0b461d930310901d4bb23b63)): ?>
<?php $component = $__componentOriginal7922fbef0b461d930310901d4bb23b63; ?>
<?php unset($__componentOriginal7922fbef0b461d930310901d4bb23b63); ?>
<?php endif; ?>
      </div>
      </div>
    </div>

    <div class="w-full bg-white rounded p-6">
      <div class="mb-6">
      <input type="text" id="search" placeholder="Search for a borrower"
      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
      </div>

      <div id="borrower-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-bold"><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></h2>
      <p class="text-gray-600">Email: <?php echo e($borrower->email); ?></p>
      <p class="text-gray-600">Contact: <?php echo e($borrower->contact_number); ?></p>
      <a href="<?php echo e(route('showBorrower', $borrower->id)); ?>"
      class="block mt-4 px-4 py-2 bg-blue-600 text-white rounded text-center hover:bg-blue-700">View</a>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>


      
      


      <!-- Pagination -->
      <div class="mt-6">
      <?php echo e($borrowers->appends(['search' => request('search')])->links()); ?>

      </div>
    <?php else: ?>
      <p class="mt-4 text-gray-500">No borrowers found.</p>
    <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/borrowers-client.blade.php ENDPATH**/ ?>