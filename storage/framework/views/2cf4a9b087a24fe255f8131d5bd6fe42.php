<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['borrowers' => null, 'borrower' => null]));

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

foreach (array_filter((['borrowers' => null, 'borrower' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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
  <template x-teleport="body">
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
      x-cloak>
      <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Create New Loan</h2>

        <form method="POST" action="<?php echo e(route('admin.loans.store')); ?>" x-data="loanCalculator()"
          @submit="formatBeforeSubmit">
          <?php echo csrf_field(); ?>


          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Borrower -->
            <div class="md:col-span-2">
              <?php if($borrower): ?>
                <input type="hidden" name="borrower_id" value="<?php echo e($borrower->id); ?>">
              <?php else: ?>
                <label class="block mb-1" for="borrower_id">Select Borrower</label>
                <select name="borrower_id" id="borrower_id" class="w-full border px-3 py-2 rounded" required>
                  <?php $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($b->id); ?>"><?php echo e($b->fname); ?> <?php echo e($b->lname); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              <?php endif; ?>
              
            </div>

            <!-- Loan Amount -->
            <div>
              <label class="block mb-1">Loan Amount</label>
              <input type="number" name="loan_amount" step="0.01" x-model.number="loan_amount"
                class="w-full border px-3 py-2 rounded" required />
            </div>

            <!-- Interest Rate (fixed) -->
            <div>
              <label class="block mb-1">Interest Rate <span class="gray-700 text-xs">(per month)</span></label>
              <input type="text" value="6%" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
            </div>

            <!-- Terms -->
            <div>
              <label class="block mb-1">Terms <span class="gray-700 text-xs">(in months)</span></label>
              <select name="terms" x-model.number="terms" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select Term</option>
                <option value="3">3 months</option>
                <option value="6">6 months</option>
                <option value="9">9 months</option>
                <option value="12">12 months</option>
              </select>
            </div>

            <!-- Processing Fee -->
            <div>
              <label class="block mb-1">Processing Fee</label>
              <input type="text" value="₱250" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
            </div>

            <!-- Due Date -->
            <div>
              <label class="block mb-1">Due Date</label>
              <input type="date" name="due_date" class="w-full border px-3 py-2 rounded" required />
            </div>
          </div>

          <!-- PREVIEW SECTION -->
          <div class="mt-6 p-4 bg-gray-50 border rounded">
            <h3 class="font-bold mb-2">Loan Preview</h3>
            <p><strong>Total Payable:</strong> <span x-text="formatCurrency(total_payable)"></span></p>
            <p><strong>Monthly Amortization:</strong> <span x-text="formatCurrency(monthly_amortization)"></span></p>
          </div>

          <div class="flex justify-end space-x-2 mt-6">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              Create Loan
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>

<script>
  function loanCalculator() {
    return {
      loan_amount: 0,
      terms: 0,
      interest_rate: 6,
      processing_fee: 250,

      get total_payable() {
        if (!this.loan_amount || !this.terms) return 0;
        let interest = this.loan_amount * (this.interest_rate / 100) * this.terms;
        return this.loan_amount + interest + this.processing_fee;
      },

      get monthly_amortization() {
        if (!this.loan_amount || !this.terms) return 0;
        return this.total_payable / this.terms;
      },

      formatCurrency(value) {
        return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
      },

      formatBeforeSubmit() {
        // Ensure values are passed to backend properly
      }
    }
  }
</script>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\components\modals\create-loan.blade.php ENDPATH**/ ?>