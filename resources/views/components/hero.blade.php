@props(['title' => 'Welcome to ABG Finance', 'subtitle' => 'Get started now.'])

<section class="relative min-h-screen flex flex-col items-center justify-center text-white px-6 bg-cover bg-center"
  style="background-image: url('{{ asset('images/hero-bg-2.jpg') }}');">

  <!-- Overlay (adds blur and dark tint) -->
  <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

  <div class="relative z-10 text-center mb-12">
    <h1 class="text-4xl font-bold mb-4">{{ $title }}</h1>
    <p class="text-lg mb-6">{{ $subtitle }}</p>
  </div>
</section>
