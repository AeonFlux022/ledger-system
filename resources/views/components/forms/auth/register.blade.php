<div class="bg-white w-full max-w-md p-6 rounded shadow-md">
  <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Register a New Account</h2>

  {{-- Validation Errors --}}
  @if ($errors->any())
    <div class="mb-4 text-sm text-red-600 bg-red-100 border border-red-300 rounded p-3">
    <ul class="list-disc pl-5 space-y-1">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
  @endif

  {{-- Registration Form --}}

  <form method="POST" action="{{ route('register') }}" class="space-y-5 mb-4">
    @csrf

    <div>
      <label class="block mb-1">Username</label>
      <input name="username"
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        value="{{ old('username') }}" required autofocus>
    </div>

    <div>
      <label class="block mb-1">Email</label>
      <input name="email" type="email"
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        value="{{ old('email') }}" required>
    </div>

    <div>
      <label class="block mb-1">Password</label>
      <input name="password" type="password"
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        required>
    </div>

    <div>
      <label class="block mb-1">Confirm Password</label>
      <input name="password_confirmation" type="password"
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        required>
    </div>

    <div class="flex justify-between items-center mt-4 gap-2">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 flex-1 rounded hover:bg-blue-700 cursor-pointer">
        Create Account
      </button>

      <a href="{{ url()->previous() }}"
        class="border border-gray-300 px-4 py-2 flex-1 text-center rounded hover:bg-gray-300 cursor-pointer">
        Go Back
      </a>
    </div>

  </form>

  <div class="text-sm text-gray-600 mb-4">
    Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>.
  </div>


</div>
