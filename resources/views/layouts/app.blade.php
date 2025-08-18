<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', '')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-100 text-gray-900">
  <div class="container mx-auto">

    @include('components.navbar')

    <main class="mx-auto">
      <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed top-4 right-4 z-50 space-y-2">

        @if (session('success'))
      <div class="bg-green-500 text-white px-4 py-3 rounded shadow flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="ml-2 text-white font-bold">&times;</button>
      </div>
    @endif

        @if ($errors->any())
      <div class="bg-red-500 text-white px-4 py-3 rounded shadow flex items-start space-x-2">
        <svg class="w-5 h-5 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <div class="text-sm">
        <strong>Whoops!</strong>
        <ul class="list-disc list-inside mt-1">
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
        </ul>
        </div>
        <button @click="show = false" class="ml-2 text-white font-bold self-start">&times;</button>
      </div>
    @endif

      </div>
      @yield('content')
    </main>

    <footer class="mt-8 text-center text-sm text-gray-600">
      &copy; {{ date('Y') }} E-Ledger for Moneylenders. All rights reserved.
    </footer>
  </div>
</body>

</html>

<script src="//unpkg.com/alpinejs" defer></script>
