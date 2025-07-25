<nav class="bg-white shadow-md">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a href="/" class="text-xl font-bold text-blue-600">ABG Finance</a>

    <ul class="flex space-x-4 items-center">
      <li><a href="/" class="text-gray-700 hover:text-blue-600">Home</a></li>


      {{-- If user is NOT logged in --}}
      @guest
      {{-- <li><a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a></li> --}}
      <li><a href="/about" class="text-gray-700 hover:text-blue-600">About Us</a></li>
      <li><a href="/service" class="text-gray-700 hover:text-blue-600">Services</a></li>
      <li><a href="/contact" class="text-gray-700 hover:text-blue-600">Contact</a></li>
      <li><a href="{{ route('login') }}" class="text-red-500 hover:underline">Login</a></li>
    @endguest

      {{-- If user IS logged in --}}
      @auth
      <li><a href="/borrowers" class="text-gray-700 hover:text-blue-600">Borrowers</a></li>
      <li><a href="/loans" class="text-gray-700 hover:text-blue-600">Loans</a></li>
      <li><a href="/transactions" class="text-gray-700 hover:text-blue-600">Transactions</a></li>
      <li><a href="/reports" class="text-gray-700 hover:text-blue-600">Reports</a></li>
      <li class="text-gray-700">Hello, <span class="font-semibold">{{ auth()->user()->username }}</span></li>

      <li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-500 hover:underline">Logout</button>
      </form>
      </li>
    @endauth
    </ul>
  </div>
</nav>
