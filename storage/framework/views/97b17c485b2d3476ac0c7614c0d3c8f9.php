<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Welcome to LoanApp', 'subtitle' => 'Simple and fast loans.']));

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

foreach (array_filter((['title' => 'Welcome to LoanApp', 'subtitle' => 'Simple and fast loans.']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<section class="bg-blue-600 text-white min-h-screen flex flex-col items-center justify-center px-6">
  <div class="text-center mb-12">
    <h1 class="text-4xl font-bold mb-4"><?php echo e($title); ?></h1>
    <p class="text-lg mb-6"><?php echo e($subtitle); ?></p>
    
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl w-full">
    <!-- Loans -->
    <a href="/loans-list"
      class="bg-white text-blue-600 p-6 rounded-2xl shadow-lg text-center transform transition hover:-translate-y-2 hover:shadow-2xl">
      <h3 class="text-xl font-semibold mb-2">Loans</h3>
      <p class="text-sm text-gray-600">Manage and track loans efficiently.</p>
    </a>

    <!-- Borrowers -->
    <a href="/borrowers"
      class="bg-white text-blue-600 p-6 rounded-2xl shadow-lg text-center transform transition hover:-translate-y-2 hover:shadow-2xl">
      <h3 class="text-xl font-semibold mb-2">Borrowers</h3>
      <p class="text-sm text-gray-600">Easily handle borrower information.</p>
    </a>

    <!-- Transactions -->
    <a href="/transactions-list"
      class="bg-white text-blue-600 p-6 rounded-2xl shadow-lg text-center transform transition hover:-translate-y-2 hover:shadow-2xl">
      <h3 class="text-xl font-semibold mb-2">Transactions</h3>
      <p class="text-sm text-gray-600">Keep track of financial transactions.</p>
    </a>
  </div>
</section>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views\components\hero.blade.php ENDPATH**/ ?>