

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-4 py-10 mx-auto max-w-4xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Borrower</h1>

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

    <div class="mt-4">
    <a href="<?php echo e(route('admin.borrowers.index')); ?>" class="text-blue-600 hover:underline">← Back to Borrowers</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/create.blade.php ENDPATH**/ ?>