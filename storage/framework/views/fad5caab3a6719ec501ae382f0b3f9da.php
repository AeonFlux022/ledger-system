

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>
  <div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Borrower</h1>
    
    <?php if (isset($component)) { $__componentOriginal7922fbef0b461d930310901d4bb23b63 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7922fbef0b461d930310901d4bb23b63 = $attributes; } ?>
<?php $component = App\View\Components\BorrowerForm::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('borrower-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\BorrowerForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['borrower' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($borrower)]); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/borrowers/edit.blade.php ENDPATH**/ ?>