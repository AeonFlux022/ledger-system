<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Admin Dashboard')</title>
  @vite('resources/css/app.css')
</head>

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

<body class="flex min-h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md p-6 space-y-4 hidden md:block">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">ABG Finance</h2>

    <nav class="space-y-2">
      <a href="/dashboard" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">Home</a>
      <a href="/users" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">Users</a>
      <a href="/borrowers" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">Borrowers</a>
      <a href="/loans" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">Loans</a>
      <a href="/transactions" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">Transactions</a>

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-red-100 text-red-500">Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-6">
    @yield('content')
  </main>

</body>

</html>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
  function updatePhilippineTime() {
    const now = new Date();

    // Convert to Philippine Time (UTC+8)
    const utc = now.getTime() + now.getTimezoneOffset() * 60000;
    const phTime = new Date(utc + 3600000 * 8);

    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
    };

    document.getElementById('ph-time').textContent = phTime.toLocaleString('en-PH', options);
  }

  // Update every second
  setInterval(updatePhilippineTime, 1000);
  updatePhilippineTime(); // Initial call
</script>
