

<?php $__env->startSection('title', 'ABG Finance - Borrower Loans'); ?>

<?php $__env->startSection('content'); ?>
  <div class="overflow-hidden mt-6 mx-4 rounded-lg border-gray-200 ">
    <div class="flex flex-row md:flex-col space-y-4 ">
    <div class="w-full p-6 rounded bg-blue-100">
      <div class="flex justify-between items-center">
      <div class="space-y-2">
        <p class="text-gray-700 text-sm"><?php echo e($borrower->id); ?> </p>
        <h1 class="text-4xl font-bold"><?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?></h1>
        <h2>Loan Applications</h2>

      </div>
      <div>
        <?php if (isset($component)) { $__componentOriginalbac49e925f1d1d239d58eb68fa33a18b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac49e925f1d1d239d58eb68fa33a18b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.create-loan','data' => ['borrower' => $borrower]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.create-loan'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['borrower' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($borrower)]); ?>
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
      </div>
      </div>

    </div>
    <div class="w-full p-6 bg-white rounded">
      <?php if($loans->count()): ?>
      <table class="w-full">
      <thead class="bg-gray-300 text-left">
      <tr>
      <th class="px-4 py-2">#</th>
      <th class="px-4 py-2">Amount</th>
      <th class="px-4 py-2">Terms</th>
      <th class="px-4 py-2">Monthly Payment</th>
      <th class="px-4 py-2">Total Payable</th>
      <th class="px-4 py-2">Loan Applied</th>
      <th class="px-4 py-2">Actions</th>
      <th class="px-4 py-2">Status</th>
      </tr>
      </thead>
      <tbody>
      <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="border-b text-left border-gray-200 hover:bg-gray-50">
      <td class="px-4 py-2"><?php echo e($loop->iteration); ?></td>
      <td class="px-4 py-2">₱<?php echo e(number_format($loan->loan_amount, 2)); ?></td>
      <td class="px-4 py-2"><?php echo e($loan->terms); ?> months</td>
      <td class="px-4 py-2">₱<?php echo e(number_format($loan->monthly_amortization, 2)); ?></td>
      <td class="px-4 py-2">₱<?php echo e(number_format($loan->total_payable, 2)); ?></td>
      <td class="px-4 py-2"><?php echo e($loan->created_at->format('M d, Y')); ?></td>
      <td class="px-4 py-2">
      <?php if($loan->status === 'approved'): ?>
      <a href="<?php echo e(route('loans.schedule', [$borrower->id, $loan->id])); ?>"
      class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
      View Schedule
      </a>
      <?php else: ?>
      <span class="text-gray-500 italic">Not available</span>
      <?php endif; ?>
      </td>
      <td class="px-4 py-2
      <?php echo e($loan->status === 'approved' ? 'bg-green-100 text-green-700' :
      ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')); ?>">
      <?php echo e(ucfirst($loan->status)); ?>

      </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
      </table>

      <div class="mt-4">
      <?php echo e($loans->links()); ?>

      </div>
    <?php else: ?>
      <p class="text-gray-500">This borrower has no loans yet.</p>
    <?php endif; ?>

      <div class="mt-6">
      <a href="<?php echo e(route('showBorrower', $borrower->id)); ?>" class="text-blue-600 hover:underline text-sm">
        ← Back to Profile
      </a>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\pages\showLoan.blade.php ENDPATH**/ ?>