<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Loans List</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #999;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <h2>ABG Finance - Loans List</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Borrower</th>
        <th>Amount</th>
        <th>Terms</th>
        <th>Status</th>
        <th>Outstanding Balance</th>
        <th>Due Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($loans as $loan)
        <tr>
          <td>{{ $loan->id }}</td>
          <td>{{ $loan->borrower->fname }} {{ $loan->borrower->lname }}</td>
          <td>{{ number_format($loan->loan_amount, 2) }}</td>
          <td>{{ $loan->terms }} mo.</td>
          <td>{{ ucfirst($loan->status) }}</td>
          <td>{{ number_format($loan->outstanding_balance, 2) }}</td>
          <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
