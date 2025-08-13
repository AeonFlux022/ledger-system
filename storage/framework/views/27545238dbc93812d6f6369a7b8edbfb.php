<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['borrowers']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['borrowers']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div x-data="{ open: false }">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
    + Add Loan
  </button>

  <!-- Modal -->
  <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
    x-cloak>
    <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">Create New Loan</h2>

      <form method="POST" action="<?php echo e(route('admin.loans.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- Borrower -->
          <div class="md:col-span-2">
            <label class="block mb-1">Borrower</label>
            <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['borrowers']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['borrowers']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

            <select name="borrower_id" class="w-full border px-3 py-2 rounded" required>
              <option value="">Select Borrower</option>
              <?php $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($borrower->id); ?>">
          <?php echo e($borrower->fname); ?> <?php echo e($borrower->lname); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <!-- Loan Amount -->
          <div>
            <label class="block mb-1">Loan Amount</label>
            <input type="number" name="loan_amount" step="0.01" class="w-full border px-3 py-2 rounded" required />
          </div>

          <!-- Interest Rate -->
          <div>
            <label class="block mb-1">Interest Rate (%)</label>
            <input type="number" name="interest_rate" step="0.01" class="w-full border px-3 py-2 rounded" required />
          </div>

          <!-- Terms -->
          <div>
            <label class="block mb-1">Terms (Months)</label>
            <input type="number" name="terms" class="w-full border px-3 py-2 rounded" required />
          </div>

          <!-- Processing Fee -->
          <div>
            <label class="block mb-1">Processing Fee</label>
            <input type="number" name="processing_fee" step="0.01" class="w-full border px-3 py-2 rounded" required />
          </div>

          <!-- Due Date -->
          <div>
            <label class="block mb-1">Due Date</label>
            <input type="date" name="due_date" class="w-full border px-3 py-2 rounded" required />
          </div>

        </div>

        <div class="flex justify-end space-x-2 mt-6">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/create-loan.blade.php ENDPATH**/ ?>