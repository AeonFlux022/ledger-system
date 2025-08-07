

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-6">Borrowers</h1>
    <?php if (isset($component)) { $__componentOriginal05412d2965d952b27d0c6e9c996d501a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal05412d2965d952b27d0c6e9c996d501a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.create-borrower','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.create-borrower'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal05412d2965d952b27d0c6e9c996d501a)): ?>
<?php $attributes = $__attributesOriginal05412d2965d952b27d0c6e9c996d501a; ?>
<?php unset($__attributesOriginal05412d2965d952b27d0c6e9c996d501a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal05412d2965d952b27d0c6e9c996d501a)): ?>
<?php $component = $__componentOriginal05412d2965d952b27d0c6e9c996d501a; ?>
<?php unset($__componentOriginal05412d2965d952b27d0c6e9c996d501a); ?>
<?php endif; ?>

    <table class="w-full bg-white shadow-md rounded border">
    <thead class="bg-gray-100 text-left">
      <tr>
      <th class="px-4 py-2">#</th>
      <th class="px-4 py-2">Name</th>
      <th class="px-4 py-2">Contact</th>
      <th class="px-4 py-2">Email</th>
      <th class="px-4 py-2">Employment</th>
      <th class="px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr class="border-t">
      <td class="px-4 py-2"><?php echo e(($borrowers->currentPage() - 1) * $borrowers->perPage() + $loop->iteration); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->contact_number); ?></td>
      <td class="px-4 py-2"><?php echo e($borrower->email); ?></td>
      <td class="px-4 py-2"><?php echo e(ucfirst($borrower->employment_status)); ?></td>
      <td class="px-4 py-2">
      <div class="flex items-center space-x-2">
      <a href="<?php echo e(route('admin.borrowers.show', $borrower->id)); ?>"
        class="inline-block bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700 transition">
        View
      </a>

      <?php if (isset($component)) { $__componentOriginala03b44d0c1aa5ee2e9bca6dcc7b68805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala03b44d0c1aa5ee2e9bca6dcc7b68805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.edit-borrower','data' => ['borrower' => $borrower,'page' => request()->query('page', 1)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.edit-borrower'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['borrower' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($borrower),'page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->query('page', 1))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala03b44d0c1aa5ee2e9bca6dcc7b68805)): ?>
<?php $attributes = $__attributesOriginala03b44d0c1aa5ee2e9bca6dcc7b68805; ?>
<?php unset($__attributesOriginala03b44d0c1aa5ee2e9bca6dcc7b68805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala03b44d0c1aa5ee2e9bca6dcc7b68805)): ?>
<?php $component = $__componentOriginala03b44d0c1aa5ee2e9bca6dcc7b68805; ?>
<?php unset($__componentOriginala03b44d0c1aa5ee2e9bca6dcc7b68805); ?>
<?php endif; ?>
      <?php if (isset($component)) { $__componentOriginalc7981b3b9e0275307745e72fd8622498 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7981b3b9e0275307745e72fd8622498 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.delete-borrower','data' => ['borrower' => $borrower]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.delete-borrower'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['borrower' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($borrower)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7981b3b9e0275307745e72fd8622498)): ?>
<?php $attributes = $__attributesOriginalc7981b3b9e0275307745e72fd8622498; ?>
<?php unset($__attributesOriginalc7981b3b9e0275307745e72fd8622498); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7981b3b9e0275307745e72fd8622498)): ?>
<?php $component = $__componentOriginalc7981b3b9e0275307745e72fd8622498; ?>
<?php unset($__componentOriginalc7981b3b9e0275307745e72fd8622498); ?>
<?php endif; ?>
      </div>

      </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
      <td colspan="5" class="px-4 py-4 text-center text-gray-500">No borrowers found.</td>
      </tr>
    <?php endif; ?>
    </tbody>
    </table>
    <div class="mt-4">
    <?php echo e($borrowers->links()); ?>

    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/index.blade.php ENDPATH**/ ?>