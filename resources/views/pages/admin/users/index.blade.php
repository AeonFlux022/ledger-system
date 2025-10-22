@extends('layouts.admin')

@section('title', 'ABG Finance')

@section('content')

  <div class="px-6 py-6">
    <h2 class="text-2xl font-bold mb-4">All Users</h2>

    <div class="flex items-center justify-between mb-4">
      {{-- Left: Create User Button --}}
      <x-modals.create-user />

      {{-- Right: Export PDF Button --}}
      <a href="{{ route('export.users') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Export Users as PDF
      </a>
    </div>


    <table class="w-full bg-white rounded shadow">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="py-2 px-4">#</th>
          <th class="py-2 px-4">Username</th>
          <th class="py-2 px-4">Email</th>
          <th class="py-2 px-4">Role</th>
          <th class="py-2 px-4">Actions</th> <!-- New column for Edit -->
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-2">{{ $loop->iteration }}</td>
            <td class="py-2 px-4">{{ $user->username }}</td>
            <td class="py-2 px-4">{{ $user->email }}</td>
            <td class="py-2 px-4">{{ ucwords(str_replace('_', ' ', $user->role)) }}</td>
            <td class="py-2 px-4">
              <x-modals.edit-user :user="$user" />
              <x-modals.delete-user :user="$user" />
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-4 px-4 text-center text-gray-500">No users found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
@endsection
