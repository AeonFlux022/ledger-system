@extends('layouts.admin')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Payments</h1>
    <div class="flex items-center justify-between mb-4">
      {{-- Left: Search Bar --}}
      <form method="GET" action="{{ route('admin.loans.payments.index') }}" class="flex items-center space-x-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search borrower..."
          class="border border-gray-300 rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200 focus:outline-none">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Search
        </button>

        @if(request('search'))
          <a href="{{ route('admin.loans.payments.index') }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Clear Search
          </a>
        @endif
      </form>

      {{-- Right: Export PDF Button --}}
      <a href="{{ route('export.payments', ['search' => request('search')]) }}"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Export Payments as PDF
      </a>

    </div>

    @if($payments->count())
      <table class="w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Loan ID</th>
            <th class="px-4 py-2">Borrower</th>
            <th class="px-4 py-2">Reference ID</th>
            <th class="px-4 py-2">Month</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $index => $payment)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-4 py-2">{{ $index + 1 }}</td>
              <td class="px-4 py-2">{{ $payment->loan->id }}</td>
              <td class="px-4 py-2">
                {{ $payment->loan->borrower->fname }} {{ $payment->loan->borrower->lname }}
              </td>
              <td class="px-4 py-2 font-mono">{{ $payment->reference_id }}</td>
              <td class="px-4 py-2">{{ $payment->month }}</td>
              <td class="px-4 py-2">₱{{ number_format($payment->amount, 2) }}</td>
              <td class="px-4 py-2">{{ $payment->created_at->format('M d, Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4">
        {{ $payments->links() }}
      </div>
    @else
      <p class="mt-4 text-gray-500">No payments found.</p>
    @endif

  </div>


  <script>
    const searchInput = document.getElementById('borrower-search');
    const resultsList = document.getElementById('borrower-results');
    const borrowerIdInput = document.getElementById('borrower_id');
    const form = document.getElementById('filter-form');

    let timeout = null;

    searchInput.addEventListener('input', function () {
      clearTimeout(timeout);
      const query = this.value.trim();

      if (!query) {
        resultsList.classList.add('hidden');
        return;
      }

      // Debounce to avoid too many requests
      timeout = setTimeout(() => {
        fetch(`{{ route('admin.borrowers.search') }}?search=${encodeURIComponent(query)}`)
          .then(response => response.json())
          .then(data => {
            resultsList.innerHTML = '';
            if (data.length === 0) {
              resultsList.innerHTML = '<li class="px-3 py-2 text-gray-500">No results found</li>';
            } else {
              data.forEach(borrower => {
                const li = document.createElement('li');
                li.textContent = `${borrower.fname} ${borrower.lname}`;
                li.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
                li.addEventListener('click', () => {
                  searchInput.value = `${borrower.fname} ${borrower.lname}`;
                  borrowerIdInput.value = borrower.id;
                  resultsList.classList.add('hidden');
                  form.submit(); // Auto-submit the form
                });
                resultsList.appendChild(li);
              });
            }
            resultsList.classList.remove('hidden');
          })
          .catch(err => console.error(err));
      }, 300);
    });

    // Hide list when clicking outside
    document.addEventListener('click', function (e) {
      if (!form.contains(e.target)) {
        resultsList.classList.add('hidden');
      }
    });
  </script>

@endsection
