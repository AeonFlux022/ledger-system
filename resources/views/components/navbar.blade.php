<nav class="bg-white shadow-md">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a href="/" class="text-xl font-bold text-blue-600">ABG Finance</a>

    <ul class="flex space-x-4">
      <li><a href="/dashboard" class="text-gray-700 hover:text-blue-600">Dashboard</a></li>
      <li><a href="/loans" class="text-gray-700 hover:text-blue-600">Loans</a></li>
      <li><a href="/borrowers" class="text-gray-700 hover:text-blue-600">Borrowers</a></li>
      <li><a href="{{ route('register') }}" class="text-red-500 hover:underline">Registration</a></li>
      {{-- <li><a href="/login" class="text-red-500 hover:underline">Login</a></li> --}}
    </ul>
  </div>
</nav>
