

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>
  <div class="px-4 py-10 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Borrower</h1>

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

    <div class="mt-4">
    <a href="<?php echo e(route('admin.borrowers.index')); ?>" class="text-blue-600 hover:underline">← Back to Borrowers</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/create.blade.php ENDPATH**/ ?>