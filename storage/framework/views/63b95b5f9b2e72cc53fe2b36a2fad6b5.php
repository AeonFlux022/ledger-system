

<?php $__env->startSection('title', 'ABG Finance - Login'); ?>

<?php $__env->startSection('content'); ?>
  <?php if (isset($component)) { $__componentOriginal34188d0268d6bcdab7ddf27a6accbed6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal34188d0268d6bcdab7ddf27a6accbed6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.auth.login','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.auth.login'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal34188d0268d6bcdab7ddf27a6accbed6)): ?>
<?php $attributes = $__attributesOriginal34188d0268d6bcdab7ddf27a6accbed6; ?>
<?php unset($__attributesOriginal34188d0268d6bcdab7ddf27a6accbed6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal34188d0268d6bcdab7ddf27a6accbed6)): ?>
<?php $component = $__componentOriginal34188d0268d6bcdab7ddf27a6accbed6; ?>
<?php unset($__componentOriginal34188d0268d6bcdab7ddf27a6accbed6); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/auth/login.blade.php ENDPATH**/ ?>