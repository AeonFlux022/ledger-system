<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Statement of Account - {{ $borrower->fname }} {{ $borrower->lname }}</title>
  @include('pdf.styles')
  <style>
    body {
      font-size: 11px;
    }

    h1 {
      font-size: 18px;
      margin-bottom: 4px;
    }

    h2 {
      font-size: 15px;
      margin-bottom: 4px;
    }

    h3 {
      font-size: 13px;
      margin-bottom: 4px;
    }

    h4 {
      font-size: 12px;
      margin-bottom: 4px;
    }

    table {
      font-size: 10px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <h1>ABG Finance</h1>
  <p><strong>Statement of Account</strong></p>
  <p>Date: {{ now()->format('F d, Y') }}</p>

  <!-- Borrower Details -->
  <h2>Borrower Details</h2>
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
    <tr>
      <td style="font-weight: bold; padding: 3px 6px;">Name:</td>
      <td style="padding: 3px 6px;">{{ $borrower->fname }} {{ $borrower->lname }}</td>
      <td style="font-weight: bold; padding: 3px 6px;">Phone:</td>
      <td style="padding: 3px 6px;">{{ $borrower->contact_number }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold; padding: 3px 6px;">Email:</td>
      <td style="padding: 3px 6px;">{{ $borrower->email ?? '—' }}</td>
      <td style="font-weight: bold; padding: 3px 6px;">Address:</td>
      <td style="padding: 3px 6px;">{{ $borrower->address ?? '—' }}</td>
    </tr>
  </table>

  <!-- Loans Section -->
  @foreach($borrower->loans as $loan)
    <div class="loan-box" style="margin-top: 15px;">
      <h3>
        Loan ID: {{ $loan->id }}
        <span class="badge 
                                    @if($loan->loan_status === 'current') badge-current
                                    @elseif($loan->loan_status === 'overdue') badge-overdue
                                    @elseif($loan->loan_status === 'completed') badge-completed
                                    @else badge-default
                                    @endif">
          {{ ucfirst($loan->loan_status ?? 'N/A') }}
        </span>
      </h3>

      <!-- Loan Details -->
      <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
          <td style="font-weight: bold; padding: 3px 6px;">Loan Amount:</td>
          <td style="padding: 3px 6px; text-align: right;">
            &#x20B1;{{ number_format($loan->loan_amount, 2) }}
          </td>
          <td style="font-weight: bold; padding: 3px 6px;">Terms:</td>
          <td style="padding: 3px 6px; text-align: right;">
            {{ $loan->terms }} months
          </td>
        </tr>
        <tr>
          <td style="font-weight: bold; padding: 3px 6px;">Outstanding Balance:</td>
          <td style="padding: 3px 6px; text-align: right;">
            &#x20B1;{{ number_format($loan->remaining_balance, 2) }}
          </td>
          <td style="font-weight: bold; padding: 3px 6px;">Payable per Term:</td>
          <td style="padding: 3px 6px; text-align: right;">
            &#x20B1;{{ number_format($loan->payable_per_term, 2) }}
          </td>
        </tr>
        {{-- add another row sa end date --}}
        <tr>
          <td style="font-weight: bold; padding: 3px 6px;">Start Date:</td>
          <td style="padding: 3px 6px; text-align: right;">
            {{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}
          </td>
          <td style="font-weight: bold; padding: 3px 6px;">Processing Fee:</td>
          <td style="padding: 3px 6px; text-align: right;">
            &#x20B1;{{ number_format($loan->processing_fee, 2) }}
          </td>
        </tr>
      </table>

      <!-- Payment History -->
      <h4>Payment History</h4>
      <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <thead>
          <tr>
            <th style="padding: 3px 6px;">No. of Payments</th>
            <th style="padding: 3px 6px;">Date</th>
            <th style="padding: 3px 6px; text-align: right;">Starting Balance</th>
            <th style="padding: 3px 6px;">Monthly Amount Due</th>
            <th style="padding: 3px 6px; text-align: right;">Penalties</th>
            <th style="padding: 3px 6px; text-align: right;">Total Payable Amount</th>
            <th style="padding: 3px 6px; text-align: right;">Payment Received</th>
            <th style="padding: 3px 6px; text-align: right;">Remaining Balance</th>
            <th style="padding: 3px 6px; text-align: center;">Reference ID</th>
          </tr>
        </thead>
        <tbody>
          @foreach($loan->payments as $payment)
            <tr>
              <td style="padding: 3px 6px; text-align: center;">
                {{ $loop->iteration }}
              </td>
              <td style="padding: 3px 6px;">
                {{ $payment->created_at->format('M d, Y') }}
              </td>
              <td style="padding: 3px 6px; text-align: right;">
                &#x20B1;{{ number_format($loan->startingBalanceBefore($payment), 2) }}
              </td>
              <td style="padding: 3px 6px; text-align: center;">
                {{ number_format($loan->monthly_amortization, 2) }}
              </td>
              <td style="padding: 3px 6px; text-align: right;">
                &#x20B1;{{ number_format($payment->penalty, 2) }}
              </td>
              <td style="padding: 3px 6px; text-align: right;">
                &#x20B1;{{ number_format($payment->total_paid, 2) }}
              </td>
              <td style="padding: 3px 6px; text-align: right;">
                &#x20B1;{{ number_format($loan->runningTotalPaid($payment), 2) }}
              </td>
              <td style="padding: 3px 6px; text-align: right;">
                &#x20B1;{{ number_format($loan->runningBalanceAfter($payment), 2) }}
              </td>

              <td style="padding: 3px 6px; text-align: center;">
                {{ $payment->reference_id }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Payment Summary -->
      <table style="width: 100%; margin-top: 6px; border-collapse: collapse;">
        <tr>
          <td style="text-align: right; font-weight: bold; padding: 3px 6px; border-top: 1px solid #ccc;">
            Total Paid:
          </td>
          <td style="text-align: right; padding: 3px 6px; border-top: 1px solid #ccc;">
            &#x20B1;{{ number_format($loan->payments->sum('total_paid'), 2) }}
          </td>
        </tr>
        <tr>
          <td style="text-align: right; font-weight: bold; padding: 3px 6px;">
            Total Penalties:
          </td>
          <td style="text-align: right; padding: 3px 6px;">
            &#x20B1;{{ number_format($loan->payments->sum('penalty'), 2) }}
          </td>
        </tr>
        <tr>
          <td style="text-align: right; font-weight: bold; padding: 3px 6px; border-top: 1px solid #ccc;">
            Remaining Balance:
          </td>
          <td style="text-align: right; padding: 3px 6px; border-top: 1px solid #ccc;">
            &#x20B1;{{ number_format($loan->remaining_balance, 2) }}
          </td>
        </tr>
      </table>
    </div>
  @endforeach

  <div class="footer">
    Generated by ABG Finance
  </div>
</body>

</html>
