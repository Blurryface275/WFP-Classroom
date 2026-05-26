<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Services</h2>          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Doctor Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Description</th>
        <th>Specialist</th>
        <th>Gender</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($doctors as $doctor)
        <tr>
            <td>{{ $doctor->id }}</td>
            <td>{{ $doctor->name }}</td>
            <td>{{ $doctor->email }}</td>
            <td>{{ $doctor->phone }}</td>
            <td>{{ $doctor->address }}</td>
            <td>{{ $doctor->description }}</td>
            <td>{{ $doctor->specialist }}</td>
            <td>{{ $doctor->gender }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>

</body>
</html>
