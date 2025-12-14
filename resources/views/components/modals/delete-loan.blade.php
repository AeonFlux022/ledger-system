@props(['action'])

<!-- Delete Loan Modal -->
<div id="deleteLoanModal"
  class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
    <h2 class="text-lg font-bold mb-2 text-gray-800">
      Confirm Delete Loan
    </h2>

    <p class="text-sm text-gray-600 mb-6">
      Are you sure you want to delete this loan?
      <br>
      <span class="text-red-600 font-medium">
        This action cannot be undone.
      </span>
    </p>

    <div class="flex justify-end space-x-3">
      <button type="button"
        onclick="closeDeleteLoanModal()"
        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">
        Cancel
      </button>

      <form id="deleteLoanForm" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit"
          class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
          Yes, Delete
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  function openDeleteLoanModal(action) {
    const modal = document.getElementById('deleteLoanModal');
    const form = document.getElementById('deleteLoanForm');

    form.action = action;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteLoanModal() {
    const modal = document.getElementById('deleteLoanModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
