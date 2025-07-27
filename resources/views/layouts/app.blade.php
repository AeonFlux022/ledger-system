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
      @yield('content')
    </main>

    <footer class="mt-8 text-center text-sm text-gray-600">
      &copy; {{ date('Y') }} E-Ledger for Moneylenders. All rights reserved.
    </footer>
  </div>
</body>

</html>

<script src="//unpkg.com/alpinejs" defer></script>
