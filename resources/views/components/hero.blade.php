@props(['title' => 'Welcome to LoanApp', 'subtitle' => 'Simple and fast loans.'])

<section class="bg-blue-600 text-white py-20">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl font-bold mb-4">{{ $title }}</h1>
    <p class="text-lg mb-6">{{ $subtitle }}</p>
    <a href="/register" class="bg-white text-blue-600 px-6 py-3 rounded hover:bg-gray-100 font-semibold">
      Get Started
    </a>
  </div>
</section>
