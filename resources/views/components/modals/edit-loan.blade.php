@props(['loan', 'borrowers'])

<div x-data="{ open: false }">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">Edit
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
      x-cloak>
      <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Edit Loan</h2>

        <form method="POST" action="{{ route('admin.loans.update', $loan->id) }}"
          x-data="loanCalculator({{ $loan->loan_amount }}, {{ $loan->terms }})" @submit="formatBeforeSubmit">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Borrower -->
            <div class="md:col-span-2">
              <label class="block mb-1" for="borrower_id">Select Borrower</label>
              <select name="borrower_id" id="borrower_id" class="w-full border px-3 py-2 rounded" required>
                @foreach ($borrowers as $b)
                  <option value="{{ $b->id }}" {{ $loan->borrower_id == $b->id ? 'selected' : '' }}>
                    {{ $b->fname }} {{ $b->lname }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Loan Amount -->
            <div>
              <label class="block mb-1">Loan Amount</label>
              <input type="number" name="loan_amount" step="0.01" x-model.number="loan_amount"
                value="{{ $loan->loan_amount }}" class="w-full border px-3 py-2 rounded" required />
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
                <option value="3" {{ $loan->terms == 3 ? 'selected' : '' }}>3 months</option>
                <option value="6" {{ $loan->terms == 6 ? 'selected' : '' }}>6 months</option>
                <option value="9" {{ $loan->terms == 9 ? 'selected' : '' }}>9 months</option>
                <option value="12" {{ $loan->terms == 12 ? 'selected' : '' }}>12 months</option>
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
              <input type="date" name="due_date" value="{{ $loan->due_date }}" class="w-full border px-3 py-2 rounded"
                required />
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
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
              Update Loan
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>

<script>
  function loanCalculator(initialAmount = 0, initialTerms = 0) {
    return {
      loan_amount: initialAmount,
      terms: initialTerms,
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
        // ensure proper formatting if needed
      }
    }
  }
</script>
