@extends('layouts.admin')

@section('title', 'SMS Logs')

@section('content')
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">SMS Logs</h1>

    <div class="bg-white shadow-md overflow-hidden rounded-lg">
      <table class="w-full text-left">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2">No.</th>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Loan ID</th>
            {{-- <th class="px-4 py-2">Borrower ID</th> --}}
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Phone Number</th>
            <th class="px-4 py-2">Message</th>
            <th class="px-4 py-2">Status</th>
          </tr>
        </thead>

        <tbody class="text-gray-700">
          @forelse ($smsLogs as $index => $log)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              {{-- Numbering (adjusts for pagination) --}}
              <td class="px-4 py-2 font-semibold">
                {{ $smsLogs->firstItem() + $index }}
              </td>

              <td class="px-4 py-2">{{ $log->created_at->format('M d, Y h:i A') }}</td>
              <td class="px-4 py-2">{{ ucfirst($log->type) }}</td>
              <td class="px-4 py-2">{{ $log->loan_id ?? '—' }}</td>
              {{-- <td class="px-4 py-2">{{ $log->borrower_id ?? '—' }}</td> --}}
              <td class="px-4 py-2">{{ $log->full_name ?: 'N/A' }}</td>
              <td class="px-4 py-2">{{ $log->phone_number }}</td>
              <td class="px-4 py-2 text-sm max-w-xs truncate" title="{{ $log->message }}">
                {{ $log->message }}
              </td>
              <td class="px-4 py-2">
                @if ($log->success)
                  <span class="text-green-600 font-semibold">Sent</span>
                @else
                  <span class="text-red-600 font-semibold">Failed</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-6 text-gray-500">
                No SMS logs found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $smsLogs->links() }}
    </div>
  </div>
@endsection
