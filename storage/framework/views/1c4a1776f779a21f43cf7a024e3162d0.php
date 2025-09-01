<div x-data="{ open: false }">
  <!-- Button to open modal -->
  <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
    + Add Borrower
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition
      x-cloak>
      <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Create New Borrower</h2>

        <form method="POST" action="<?php echo e(route('admin.borrowers.store')); ?>" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block mb-1">First Name</label>
              <input name="fname" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Last Name</label>
              <input name="lname" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div class="md:col-span-2">
              <label class="block mb-1">Address</label>
              <input name="address" class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
              <label class="block mb-1">Contact Number</label>
              <input type="tel" name="contact_number" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Email</label>
              <input type="email" name="email" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Employment Status</label>
              <select name="employment_status" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select</option>
                <option value="employed">Employed</option>
                <option value="unemployed">Unemployed</option>
              </select>
            </div>

            <div>
              <div class="flex justify-between items-center mb-1">
                <label class="text-sm text-gray-700">Income</label>
                <span class="text-xs text-gray-500">Average income per month</span>
              </div>
              <input type="number" name="income" class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
              <label class="block mb-1">ID Type</label>
              <select name="id_card" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select ID Type</option>
                <option value="passport">Passport</option>
                <option value="driver_license">Driver’s License</option>
                <option value="sss">SSS</option>
                <option value="philhealth">PhilHealth</option>
                <option value="pagibig">Pag-IBIG</option>
                <option value="national_id">National ID</option>
                <option value="voter_id">Voter’s ID</option>
                <option value="student_id">Student ID</option>
              </select>
            </div>

            <div>
              <label class="block mb-1">ID Image</label>
              <input type="file" name="id_image" accept="image/*" class="w-full border px-3 py-2 rounded" />
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
  </template>
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/modals/create-borrower.blade.php ENDPATH**/ ?>