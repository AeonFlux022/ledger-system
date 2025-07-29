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

<section class="bg-blue-600 text-white py-20">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl font-bold mb-4"><?php echo e($title); ?></h1>
    <p class="text-lg mb-6"><?php echo e($subtitle); ?></p>
    <a href="/register" class="bg-white text-blue-600 px-6 py-3 rounded hover:bg-gray-100 font-semibold">
      Get Started
    </a>
  </div>
</section>
<?php /**PATH C:\xampp\htdocs\ledger-system\resources\views/components/hero.blade.php ENDPATH**/ ?>