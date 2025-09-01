

<?php $__env->startSection('title', 'ABG Finance - Register'); ?>

<?php $__env->startSection('content'); ?>
  <?php if (isset($component)) { $__componentOriginal8326c2b9aa6936ef3a6b3395ececc996 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8326c2b9aa6936ef3a6b3395ececc996 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.auth.register','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.auth.register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8326c2b9aa6936ef3a6b3395ececc996)): ?>
<?php $attributes = $__attributesOriginal8326c2b9aa6936ef3a6b3395ececc996; ?>
<?php unset($__attributesOriginal8326c2b9aa6936ef3a6b3395ececc996); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8326c2b9aa6936ef3a6b3395ececc996)): ?>
<?php $component = $__componentOriginal8326c2b9aa6936ef3a6b3395ececc996; ?>
<?php unset($__componentOriginal8326c2b9aa6936ef3a6b3395ececc996); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\auth\register.blade.php ENDPATH**/ ?>