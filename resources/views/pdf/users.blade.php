<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Users List</title>
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
  <h2>ABG Finance - Users List</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->username }} </td>
          <td>{{ $user->email }}</td>
          <td>{{ ucfirst($user->role) }}</td>
          <td>{{ $user->created_at->format('M d, Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
