@extends('layouts.admin')

@section('title', 'ABG Finance')

@section('content')
  <div class="container mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-6">Borrowers</h1>
    <x-modals.create-borrower />

    <table class="w-full bg-white shadow-md rounded">
    <thead class="bg-gray-100 text-left">
      <tr>
      <th class="px-4 py-2">#</th>
      <th class="px-4 py-2">Name</th>
      <th class="px-4 py-2">Contact</th>
      <th class="px-4 py-2">Email</th>
      <th class="px-4 py-2">Employment</th>
      <th class="px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($borrowers as $borrower)
      <tr class="border-b border-gray-200 hover:bg-gray-50">
      <td class="px-4 py-2">{{ ($borrowers->currentPage() - 1) * $borrowers->perPage() + $loop->iteration }}</td>
      <td class="px-4 py-2">{{ $borrower->fname }} {{ $borrower->lname }}</td>
      <td class="px-4 py-2">{{ $borrower->contact_number }}</td>
      <td class="px-4 py-2">{{ $borrower->email }}</td>
      <td class="px-4 py-2">{{ ucfirst($borrower->employment_status) }}</td>
      <td class="px-4 py-2">
      <div class="flex items-center space-x-2">
      <a href="{{ route('admin.borrowers.show', $borrower->id) }}"
        class="inline-block bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700 transition">
        View
      </a>

      <x-modals.edit-borrower :borrower="$borrower" :page="request()->query('page', 1)" />
      <x-modals.delete-borrower :borrower="$borrower" />
      </div>

      </td>
      </tr>
    @empty
      <tr>
      <td colspan="5" class="px-4 py-4 text-center text-gray-500">No borrowers found.</td>
      </tr>
    @endforelse
    </tbody>
    </table>
    <div class="mt-4">
    {{ $borrowers->links() }}
    </div>
  </div>
@endsection
