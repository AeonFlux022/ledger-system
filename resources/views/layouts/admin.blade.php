<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Admin Dashboard')</title>
  @vite('resources/css/app.css')
</head>

<body class="flex min-h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md p-6 space-y-4 hidden md:block">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">ABG Admin</h2>

    <nav class="space-y-2">
      <a href="/dashboard" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">🏠 Home</a>
      <a href="/admin" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">👤 Admin</a>
      <a href="/super-admin" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">👑 Super Admin</a>
      <a href="/borrowers" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">📋 Borrowers</a>
      <a href="/loans" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">💰 Loans</a>
      <a href="/transactions" class="block px-4 py-2 rounded hover:bg-blue-100 text-gray-700">💳 Transactions</a>

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-red-100 text-red-500">🚪
          Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-6">
    @yield('content')
  </main>

</body>

</html>
