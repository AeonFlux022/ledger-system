<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Monthly Payments Report - {{ $month }}</title>
  <style>
    /* --- Reset / Base Styles --- */
    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #1f2937;
      /* text-gray-800 */
      font-size: 12px;
      margin: 10px;
      background-color: #ffffff;
    }

    h1,
    h2,
    h3,
    h4 {
      margin: 0;
      padding: 0;
    }

    /* --- Header --- */
    .header {
      text-align: center;
      margin-bottom: 10px;
    }

    .header h1 {
      font-size: 20px;
      font-weight: 700;
      color: #111827;
      /* gray-900 */
      margin-bottom: 4px;
    }

    .header p {
      color: #6b7280;
      /* gray-500 */
      font-size: 12px;
    }

    /* --- Table Styles --- */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      padding: 8px 10px;
      border: 1px solid #e5e7eb;
      /* gray-200 */
      text-align: left;
    }

    th {
      background-color: #f3f4f6;
      /* gray-100 */
      font-weight: 600;
      color: #374151;
      /* gray-700 */
    }

    tr:nth-child(even) {
      background-color: #f9fafb;
      /* gray-50 */
    }

    /* --- Summary Box --- */
    .summary {
      margin-top: 30px;
      padding: 15px;
      border: 1px solid #d1d5db;
      /* gray-300 */
      border-radius: 8px;
      background-color: #f9fafb;
      width: 50%;
    }

    .summary h3 {
      font-size: 14px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
    }

    .summary p {
      font-size: 13px;
      margin: 4px 0;
      color: #374151;
    }

    /* --- Footer --- */
    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 11px;
      color: #9ca3af;
      /* gray-400 */
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>Monthly Payments Report</h1>
    <p><strong>Month:</strong> {{ $month }}</p>
    <p><strong>Generated on:</strong> {{ now()->format('F d, Y h:i A') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Borrower</th>
        <th>Loan ID</th>
        <th>Reference ID</th>
        <th>Term</th>
        <th>Amount</th>
        <th>Penalty</th>
        <th>Total Paid</th>
        <th>Date Paid</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $index => $payment)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $payment->loan->borrower->fname }} {{ $payment->loan->borrower->lname }}</td>
          <td>{{ $payment->loan->id }}</td>
          <td>{{ $payment->reference_id }}</td>
          <td>{{ $payment->month }}</td>
          <td>₱{{ number_format($payment->amount, 2) }}</td>
          <td>₱{{ number_format($payment->penalty, 2) }}</td>
          <td><strong>₱{{ number_format($payment->amount + $payment->penalty, 2) }}</strong></td>
          <td>{{ $payment->created_at->format('M d, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="summary">
    <h3>Summary</h3>
    <p><strong>Total Amount:</strong> ₱{{ number_format($totalAmount, 2) }}</p>
    <p><strong>Total Penalty:</strong> ₱{{ number_format($totalPenalty, 2) }}</p>
    <p><strong>Grand Total Collected:</strong> ₱{{ number_format($grandTotal, 2) }}</p>
  </div>

  <div class="footer">
    <p>ABG Finance — Monthly Payments Report | {{ now()->format('F Y') }}</p>
  </div>
</body>

</html>
