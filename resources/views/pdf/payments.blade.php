<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Payments List</title>
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
  <h2>ABG Finance - Payments List</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Borrower</th>
        <th>Loan ID</th>
        <th>Month</th>
        <th>Amount</th>
        <th>Reference</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->loan->borrower->fname }} {{ $p->loan->borrower->lname }}</td>
          <td>{{ $p->loan_id }}</td>
          <td>{{ $p->month }} mo.</td>
          <td>{{ number_format($p->amount, 2) }}</td>
          <td>{{ $p->reference_id }}</td>
          <td>{{ $p->created_at->format('M d, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
