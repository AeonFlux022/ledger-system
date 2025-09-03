

<?php $__env->startSection('content'); ?>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Loans</h1>
    <?php if (isset($component)) { $__componentOriginalbac49e925f1d1d239d58eb68fa33a18b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac49e925f1d1d239d58eb68fa33a18b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.create-loan','data' => ['borrowers' => $borrowers]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.create-loan'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['borrowers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($borrowers)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbac49e925f1d1d239d58eb68fa33a18b)): ?>
<?php $attributes = $__attributesOriginalbac49e925f1d1d239d58eb68fa33a18b; ?>
<?php unset($__attributesOriginalbac49e925f1d1d239d58eb68fa33a18b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbac49e925f1d1d239d58eb68fa33a18b)): ?>
<?php $component = $__componentOriginalbac49e925f1d1d239d58eb68fa33a18b; ?>
<?php unset($__componentOriginalbac49e925f1d1d239d58eb68fa33a18b); ?>
<?php endif; ?>

    <table class="w-full bg-white shadow-md rounded">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="px-4 p-2">#</th>
          <th class="px-4 p-2">Borrower</th>
          <th class="px-4 p-2">Loan Amount</th>
          <th class="px-4 p-2">Interest Rate</th>
          <th class="px-4 p-2">Terms</th>
          <th class="px-4 p-2">Due Date</th>
          <th class="px-4 py-2">Outstanding Balance</th>
          <th class="px-4 p-2">Actions</th>
          <th class="px-4 p-2">Status</th>

        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-4 py-2">
                <?php echo e(($loans->currentPage() - 1) * $loans->perPage() + $loop->iteration); ?>

              </td>
              <td class="px-4 py-2"><?php echo e($loan->borrower->fname); ?> <?php echo e($loan->borrower->lname); ?></td>
              <td class="px-4 py-2">&#8369;<?php echo e(number_format($loan->loan_amount, 2)); ?></td>
              <td class="px-4 py-2"><?php echo e($loan->interest_rate); ?>%</td>
              <td class="px-4 py-2"><?php echo e($loan->terms); ?> months</td>
              <td class="px-4 py-2"><?php echo e($loan->due_date); ?></td>
              <td class="px-4 py-2">₱<?php echo e(number_format($loan->outstanding_balance, 2)); ?></td>
              <td class="px-4 py-2">
                <a href="<?php echo e(route('admin.loans.show', $loan->id)); ?>" class="inline-block bg-blue-600 text-white
                  text-sm px-4 py-2 rounded hover:bg-blue-700 transition">View</a>
              </td>
              <td class="px-4 py-2 capitalize rounded 
                  <?php echo e($loan->status === 'approved' ? 'bg-green-100 text-green-700' :
          ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')); ?>">
                <?php echo e($loan->status); ?>

              </td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
              No loans found.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-4">
      <?php echo e($loans->links()); ?>

    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\admin\loans\index.blade.php ENDPATH**/ ?>