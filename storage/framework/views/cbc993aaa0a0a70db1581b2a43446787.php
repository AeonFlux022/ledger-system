

<?php $__env->startSection('title', 'ABG Finance'); ?>

<?php $__env->startSection('content'); ?>

  <div class="px-6 py-6">
    <h2 class="text-2xl font-bold mb-4">All Users</h2>

    <?php if (isset($component)) { $__componentOriginal3a20a4b44ede0aa67600cb329d2394bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a20a4b44ede0aa67600cb329d2394bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.create-user','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.create-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a20a4b44ede0aa67600cb329d2394bc)): ?>
<?php $attributes = $__attributesOriginal3a20a4b44ede0aa67600cb329d2394bc; ?>
<?php unset($__attributesOriginal3a20a4b44ede0aa67600cb329d2394bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a20a4b44ede0aa67600cb329d2394bc)): ?>
<?php $component = $__componentOriginal3a20a4b44ede0aa67600cb329d2394bc; ?>
<?php unset($__componentOriginal3a20a4b44ede0aa67600cb329d2394bc); ?>
<?php endif; ?>

    <table class="w-full bg-white rounded shadow">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="py-2 px-4">#</th>
          <th class="py-2 px-4">Username</th>
          <th class="py-2 px-4">Email</th>
          <th class="py-2 px-4">Role</th>
          <th class="py-2 px-4">Actions</th> <!-- New column for Edit -->
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo e($loop->iteration); ?></td>
            <td class="py-2 px-4"><?php echo e($user->username); ?></td>
            <td class="py-2 px-4"><?php echo e($user->email); ?></td>
            <td class="py-2 px-4"><?php echo e(ucwords(str_replace('_', ' ', $user->role))); ?></td>
            <td class="py-2 px-4">
              <?php if (isset($component)) { $__componentOriginal2e59eabd9e214f2f072383a77675086f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e59eabd9e214f2f072383a77675086f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.edit-user','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.edit-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e59eabd9e214f2f072383a77675086f)): ?>
<?php $attributes = $__attributesOriginal2e59eabd9e214f2f072383a77675086f; ?>
<?php unset($__attributesOriginal2e59eabd9e214f2f072383a77675086f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e59eabd9e214f2f072383a77675086f)): ?>
<?php $component = $__componentOriginal2e59eabd9e214f2f072383a77675086f; ?>
<?php unset($__componentOriginal2e59eabd9e214f2f072383a77675086f); ?>
<?php endif; ?>
              <?php if (isset($component)) { $__componentOriginal863731c81cba5a737041869952c7949c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal863731c81cba5a737041869952c7949c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.delete-user','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.delete-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal863731c81cba5a737041869952c7949c)): ?>
<?php $attributes = $__attributesOriginal863731c81cba5a737041869952c7949c; ?>
<?php unset($__attributesOriginal863731c81cba5a737041869952c7949c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal863731c81cba5a737041869952c7949c)): ?>
<?php $component = $__componentOriginal863731c81cba5a737041869952c7949c; ?>
<?php unset($__componentOriginal863731c81cba5a737041869952c7949c); ?>
<?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="py-4 px-4 text-center text-gray-500">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\admin\users\index.blade.php ENDPATH**/ ?>