@props(['loan', 'borrowers'])

<div x-data="{ open: false }" x-key="loan-{{ $loan->id }}">
  <!-- Trigger -->
  <button type="button" @click="open = true"
    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
    Edit
  </button>

  <!-- Modal Backdrop -->
  <div x-show="open" x-cloak x-transition.opacity
    class="fixed inset-0 bg-black/50 flex items-start justify-center py-16 z-50">
    <!-- Modal Card -->
    <div @click.outside="open = false" x-data="loanCalculator({{ $loan->loan_amount }}, {{ $loan->terms }})"
      x-transition.scale class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 rounded shadow-lg">
      <h2 class="text-lg font-bold mb-4">Edit Loan</h2>

      <form method="POST" action="{{ route('admin.loans.update', $loan->id) }}" @submit="formatBeforeSubmit">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Borrower -->
          <div class="md:col-span-2">
            <label class="block mb-1">Select Borrower</label>
            <select name="borrower_id" class="w-full border px-3 py-2 rounded" required>
              @foreach ($borrowers as $b)
                <option value="{{ $b->id }}" @selected($loan->borrower_id == $b->id)>
                  {{ $b->fname }} {{ $b->lname }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Loan Amount -->
          <div>
            <label class="block mb-1">Loan Amount</label>
            <input type="number" name="loan_amount" step="0.01" x-model.number="loan_amount"
              class="w-full border px-3 py-2 rounded" required>
          </div>

          <!-- Interest -->
          <div>
            <label class="block mb-1">Interest Rate (per month)</label>
            <input type="text" value="6%" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
          </div>

          <!-- Terms -->
          <div>
            <label class="block mb-1">Terms (months)</label>
            <select name="terms" x-model.number="terms" class="w-full border px-3 py-2 rounded" required>
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
            <input type="date" name="due_date" value="{{ $loan->due_date }}" class="w-full border px-3 py-2 rounded"
              required>
          </div>
        </div>

        <!-- Preview -->
        <div class="mt-6 p-4 bg-gray-50 border rounded">
          <h3 class="font-bold mb-2">Loan Preview</h3>
          <p><strong>Total Payable:</strong>
            <span x-text="formatCurrency(total_payable)"></span>
          </p>
          <p><strong>Monthly Amortization:</strong>
            <span x-text="formatCurrency(monthly_amortization)"></span>
          </p>
        </div>

        <div class="flex justify-end gap-2 mt-6">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">
            Cancel
          </button>

          <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
            Update Loan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
