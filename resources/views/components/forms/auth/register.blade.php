<form method="POST" action="{{ route('register') }}" class="space-y-4">
  @csrf

  <div>
    <label class="block mb-1">Name</label>
    <input name="name" class="w-full border px-3 py-2 rounded" value="{{ old('name') }}" required>
  </div>

  <div>
    <label class="block mb-1">Email</label>
    <input name="email" type="email" class="w-full border px-3 py-2 rounded" value="{{ old('email') }}" required>
  </div>

  <div>
    <label class="block mb-1">Password</label>
    <input name="password" type="password" class="w-full border px-3 py-2 rounded" required>
  </div>

  <div>
    <label class="block mb-1">Confirm Password</label>
    <input name="password_confirmation" type="password" class="w-full border px-3 py-2 rounded" required>
  </div>

  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
</form>
