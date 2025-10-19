<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Borrowers List</title>
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
  </style>
</head>

<body>
  <h2>ABG Finance - Borrowers List</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      @foreach($borrowers as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->fname }} {{ $b->lname }}</td>
          <td>{{ $b->contact_number }}</td>
          <td>{{ $b->address }}</td>
          <td>{{ $b->created_at->format('M d, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
