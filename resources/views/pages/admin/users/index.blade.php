@extends('layouts.admin')

@section('title', 'ABG Finance')

@section('content')

  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">All Users</h2>

    <x-modals.create-user />

    <table class="w-full bg-white border rounded shadow">
    <thead>
      <tr class="bg-gray-100 text-left">
      <th class="py-2 px-4 border-b">#</th>
      <th class="py-2 px-4 border-b">Username</th>
      <th class="py-2 px-4 border-b">Email</th>
      <th class="py-2 px-4 border-b">Role</th>
      <th class="py-2 px-4 border-b">Actions</th> <!-- New column for Edit -->
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $user)
      <tr class="border-t hover:bg-gray-50">
      <td class="px-4 py-2">{{ $loop->iteration }}</td>
      <td class="py-2 px-4">{{ $user->username }}</td>
      <td class="py-2 px-4">{{ $user->email }}</td>
      <td class="py-2 px-4 capitalize">{{ $user->role }}</td>
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
