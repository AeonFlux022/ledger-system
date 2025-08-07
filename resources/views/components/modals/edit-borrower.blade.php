@props(['borrower', 'page'])

<div x-data="{ open: false }">
  <!-- Trigger Button -->
  <button @click="open = true" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
    Edit
  </button>

  <!-- Modal -->
  <div x-show="open" x-cloak x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div @click.outside="open = false" class="bg-white w-full max-w-2xl p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">Edit Borrower</h2>

      <form method="POST" action="{{ route('admin.borrowers.update', $borrower->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="page" value="{{ $page }}">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1">First Name</label>
            <input name="fname" value="{{ $borrower->fname }}" class="w-full border px-3 py-2 rounded" required />
          </div>

          <div>
            <label class="block mb-1">Last Name</label>
            <input name="lname" value="{{ $borrower->lname }}" class="w-full border px-3 py-2 rounded" required />
          </div>

          <div class="md:col-span-2">
            <label class="block mb-1">Address</label>
            <input name="address" value="{{ $borrower->address }}" class="w-full border px-3 py-2 rounded" />
          </div>

          <div>
            <label class="block mb-1">Contact Number</label>
            <input type="tel" name="contact_number" value="{{ $borrower->contact_number }}"
              class="w-full border px-3 py-2 rounded" required />
          </div>

          <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ $borrower->email }}" class="w-full border px-3 py-2 rounded"
              required />
          </div>

          <div>
            <label class="block mb-1">Employment Status</label>
            <select name="employment_status" class="w-full border px-3 py-2 rounded" required>
              @foreach (['employed', 'unemployed'] as $status)
          <option value="{{ $status }}" @selected($borrower->employment_status === $status)>
          {{ ucfirst($status) }}
          </option>
        @endforeach
            </select>
          </div>

          <div>
            <div class="flex justify-between items-center mb-1">
              <label class="text-sm text-gray-700">Income</label>
              <span class="text-xs text-gray-500">Average income per month</span>
            </div>
            <input type="number" name="income" value="{{ $borrower->income }}"
              class="w-full border px-3 py-2 rounded" />
          </div>


          <div>
            <label class="block mb-1">ID Type</label>
            <select name="id_card" class="w-full border px-3 py-2 rounded" required>
              @foreach (['passport', 'driver_license', 'sss', 'philhealth', 'pagibig', 'national_id', 'voter_id'] as $id)
          <option value="{{ $id }}" @selected($borrower->id_card === $id)>
          {{ ucwords(str_replace('_', ' ', $id)) }}
          </option>
        @endforeach
            </select>
          </div>

          <div>
            <label class="block mb-1">Current ID Image</label>
            <div class="mb-2">
              @if ($borrower->id_image)
          <img src="{{ asset($borrower->id_image) }}" alt="ID Image" class="h-32 object-contain rounded" />

        @else
          <p class="text-sm text-gray-500">No image uploaded.</p>
        @endif
            </div>

            <label class="block mb-1">Replace ID Image</label>
            <input type="file" name="id_image" accept="image/*" class="w-full border px-3 py-2 rounded" />
          </div>

        </div>

        <div class="flex justify-end space-x-2 mt-6">
          <button type="button" @click="open = false" class="px-4 py-2 border rounded">
            Cancel
          </button>
          <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
