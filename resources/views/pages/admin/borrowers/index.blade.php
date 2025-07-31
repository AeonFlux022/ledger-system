@extends('layouts.admin') {{-- or layouts.app if you don’t have separate admin layout --}}

@section('title', 'ABG Finance')

@section('content')
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Borrowers</h1>

    <table class="w-full bg-white shadow-md rounded border">
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
      <tr class="border-t">
      <td class="px-4 py-2">{{ $loop->iteration }}</td>
      <td class="px-4 py-2">{{ $borrower->fname }} {{ $borrower->lname }}</td>
      <td class="px-4 py-2">{{ $borrower->contact_number }}</td>
      <td class="px-4 py-2">{{ $borrower->email }}</td>
      <td class="px-4 py-2">{{ ucfirst($borrower->employment_status) }}</td>
      <td class="px-4 py-2">
      <a href="{{ route('admin.borrowers.show', $borrower->id) }}" class="text-blue-600 hover:underline">View</a>

      {{-- Later add Edit/Delete --}}
      </td>
      </tr>
    @empty
      <tr>
      <td colspan="5" class="px-4 py-4 text-center text-gray-500">No borrowers found.</td>
      </tr>
    @endforelse
    </tbody>
    </table>
  </div>
@endsection
