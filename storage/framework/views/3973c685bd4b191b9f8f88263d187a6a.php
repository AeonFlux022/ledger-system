

<?php $__env->startSection('title', 'ABG Finance - Loan Details'); ?>

<?php $__env->startSection('content'); ?>
  <div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-2">Loan Details</h1>
    <p class="text-sm text-gray-500 mb-6">
      Submitted at <?php echo e($loan->created_at->format('F j, Y g:i A')); ?>

    </p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 space-y-8">
      <!-- Borrower Details -->
      <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Borrower Details</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
          <div>
            <label class="text-sm text-gray-500">Full Name</label>
            <p class="mt-1 font-medium"><?php echo e($loan->borrower->fname); ?> <?php echo e($loan->borrower->lname); ?></p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Email</label>
            <p class="mt-1 font-medium"><?php echo e($loan->borrower->email); ?></p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Contact Number</label>
            <p class="mt-1 font-medium"><?php echo e($loan->borrower->contact_number); ?></p>
          </div>

          <div class="md:col-span-2">
            <label class="text-sm text-gray-500">Address</label>
            <p class="mt-1 font-medium"><?php echo e($loan->borrower->address); ?></p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Income <span class="text-xs">(Average per month)</span></label>
            <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->borrower->income, 2)); ?></p>
          </div>

          <div>
            <label class="text-sm text-gray-500">Employment Status</label>
            <p class="mt-1 font-medium"><?php echo e(ucwords($loan->borrower->employment_status)); ?></p>
          </div>

          <div>
            <label class="text-sm text-gray-500">ID Provided</label>
            <p class="mt-1 font-medium"><?php echo e(ucwords(str_replace('_', ' ', $loan->borrower->id_card))); ?></p>
          </div>
        </div>
      </div>
      <hr>

      <!-- Loan Info -->
      <h3 class="text-lg font-bold text-gray-800 mb-4">Loan Details</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
        <div>
          <label class="text-sm text-gray-500">Loan Amount</label>
          <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->loan_amount, 2)); ?></p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Interest Rate</label>
          <p class="mt-1 font-medium"><?php echo e($loan->interest_rate); ?>% per month</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Terms</label>
          <p class="mt-1 font-medium"><?php echo e($loan->terms); ?> months</p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Processing Fee</label>
          <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->processing_fee, 2)); ?></p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Total Payable</label>
          <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->total_payable, 2)); ?></p>
        </div>
        <div>
          <label class="text-sm text-gray-500">Monthly Amortization</label>
          <p class="mt-1 font-medium">₱<?php echo e(number_format($loan->monthly_amortization, 2)); ?></p>
        </div>
      </div>
      <hr>

      <!-- Amortization Table -->
      <h3 class="text-lg font-bold text-gray-800 mb-4">Amortization Schedule</h3>
      <table class="w-full">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-2">Month</th>
            <th class="px-4 py-2">Due Date</th>
            <th class="px-4 py-2">Amount</th>

            <?php if($loan->status === 'approved'): ?>
              <th class="px-4 py-2">Action</th>
              <th class="px-4 py-2">Date Paid</th>
            <?php endif; ?>
          </tr>
        </thead>

        <tbody>
          <?php $__currentLoopData = $paginatedSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $paid = $loan->payments->firstWhere('month', $payment['month']);
            ?>

            <tr class="border-b border-gray-200 hover:bg-gray-50 text-left">
              <td class="px-4 py-2"><?php echo e($payment['month']); ?></td>
              <td class="px-4 py-2"><?php echo e($payment['due_date']); ?></td>
              <td class="px-4 py-2">₱<?php echo e(number_format($payment['amount'], 2)); ?></td>

              <?php if($loan->status === 'approved'): ?>
                <td class="px-4 py-2">
                  <?php if($paid): ?>
                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                      Paid
                    </button>
                  <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalf3c793c3a7c34238c896370001632b05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3c793c3a7c34238c896370001632b05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.create-payment','data' => ['loan' => $loan,'payment' => $payment]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.create-payment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loan),'payment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($payment)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3c793c3a7c34238c896370001632b05)): ?>
<?php $attributes = $__attributesOriginalf3c793c3a7c34238c896370001632b05; ?>
<?php unset($__attributesOriginalf3c793c3a7c34238c896370001632b05); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3c793c3a7c34238c896370001632b05)): ?>
<?php $component = $__componentOriginalf3c793c3a7c34238c896370001632b05; ?>
<?php unset($__componentOriginalf3c793c3a7c34238c896370001632b05); ?>
<?php endif; ?>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-2">
                  <?php if($paid): ?>
                    <?php echo e($paid->created_at->format('F j, Y')); ?>

                  <?php else: ?>
                    <span class="text-gray-400 italic">—</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>

      <div class="mt-4">
        <?php echo e($paginatedSchedule->links()); ?>

      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-2 mt-6">
        <?php if($loan->status === 'pending'): ?>
          <form method="POST" action="<?php echo e(route('admin.loans.approve', $loan->id)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
              Approve
            </button>
          </form>

          <form method="POST" action="<?php echo e(route('admin.loans.decline', $loan->id)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
              Decline
            </button>
          </form>
        <?php endif; ?>
      </div>

    </div>

    <div class="mt-6">
      <a href="<?php echo e(route('admin.loans.index')); ?>" class="text-blue-600 hover:underline text-sm">← Back to list</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/pages/admin/loans/show.blade.php ENDPATH**/ ?>