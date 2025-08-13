

<?php $__env->startSection('title', 'ABG Finance - Borrowers'); ?>

<?php $__env->startSection('content'); ?>
  <?php if(auth()->guard()->check()): ?>
    <section class="bg-blue-600 text-white py-20">
    <div class="container mx-auto px-6 text-center">
    <h1 class="text-4xl font-bold mb-4">Borrowers Page</h1>
    <p class="text-lg mb-6">Some subtitle short description</p>
    </div>
    </section>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-bold">Fill out the information of the borrower to continue.</h2>
    <p class="mb-4">Here you can manage your borrowers.</p>

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
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/client/borrowers-client.blade.php ENDPATH**/ ?>