<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['loan', 'payment']));

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

foreach (array_filter((['loan', 'payment']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div x-data="{ open: false }" class="inline-block">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
    Add Payment
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      x-transition>
      <div @click.outside="open = false" class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">

        <h2 class="text-xl font-bold mb-4">
          Add Payment for Loan #<?php echo e($loan->id); ?>

        </h2>
        <form method="POST" action="<?php echo e(route('admin.transactions.store', $loan->id)); ?> class=" space-y-4>
          <?php echo csrf_field(); ?>

          <div>
            <label class="block mb-1 font-medium">Amount</label>
            <input type="number" name="amount" value="<?php echo e($payment['amount']); ?>" step="0.01"
              class="w-full border px-4 py-2 rounded mb-3" required>
          </div>

          <div class="flex justify-end space-x-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">
              Cancel
            </button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              Save Transaction
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/create-transaction.blade.php ENDPATH**/ ?>