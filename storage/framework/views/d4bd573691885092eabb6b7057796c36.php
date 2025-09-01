<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['borrower', 'page']));

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

foreach (array_filter((['borrower', 'page']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div x-data="{ open: false }">
  <!-- Trigger Button -->
  <button @click="open = true" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
    Edit
  </button>

  <!-- Modal -->
  <template x-teleport="body">
    <div x-show="open" x-cloak x-transition
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Edit Borrower</h2>

        <form method="POST" action="<?php echo e(route('admin.borrowers.update', $borrower->id)); ?>" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          <input type="hidden" name="page" value="<?php echo e($page); ?>">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block mb-1">First Name</label>
              <input name="fname" value="<?php echo e($borrower->fname); ?>" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Last Name</label>
              <input name="lname" value="<?php echo e($borrower->lname); ?>" class="w-full border px-3 py-2 rounded" required />
            </div>

            <div class="md:col-span-2">
              <label class="block mb-1">Address</label>
              <input name="address" value="<?php echo e($borrower->address); ?>" class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
              <label class="block mb-1">Contact Number</label>
              <input type="tel" name="contact_number" value="<?php echo e($borrower->contact_number); ?>"
                class="w-full border px-3 py-2 rounded" required />
            </div>

            <div>
              <label class="block mb-1">Email</label>
              <input type="email" name="email" value="<?php echo e($borrower->email); ?>" class="w-full border px-3 py-2 rounded"
                required />
            </div>

            <div>
              <label class="block mb-1">Employment Status</label>
              <select name="employment_status" class="w-full border px-3 py-2 rounded" required>
                <?php $__currentLoopData = ['employed', 'unemployed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($status); ?>" <?php if($borrower->employment_status === $status): echo 'selected'; endif; ?>>
                    <?php echo e(ucfirst($status)); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div>
              <div class="flex justify-between items-center mb-1">
                <label class="text-sm text-gray-700">Income</label>
                <span class="text-xs text-gray-500">Average income per month</span>
              </div>
              <input type="number" name="income" value="<?php echo e($borrower->income); ?>"
                class="w-full border px-3 py-2 rounded" />
            </div>


            <div>
              <label class="block mb-1">ID Type</label>
              <select name="id_card" class="w-full border px-3 py-2 rounded" required>
                <?php $__currentLoopData = ['passport', 'driver_license', 'sss', 'philhealth', 'pagibig', 'national_id', 'voter_id']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($id); ?>" <?php if($borrower->id_card === $id): echo 'selected'; endif; ?>>
                    <?php echo e(ucwords(str_replace('_', ' ', $id))); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div>
              <label class="block mb-1">Current ID Image</label>
              <div class="mb-2">
                <?php if($borrower->id_image): ?>
                  <img src="<?php echo e(asset($borrower->id_image)); ?>" alt="ID Image" class="h-32 object-contain rounded" />

                <?php else: ?>
                  <p class="text-sm text-gray-500">No image uploaded.</p>
                <?php endif; ?>
              </div>

              <label class="block mb-1">Replace ID Image</label>
              <input type="file" name="id_image" accept="image/*" class="w-full border px-3 py-2 rounded" />
            </div>

          </div>

          <div class="flex justify-end space-x-2 mt-6">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">
              Cancel
            </button>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
</div>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\components\modals\edit-borrower.blade.php ENDPATH**/ ?>