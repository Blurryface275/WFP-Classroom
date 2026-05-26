<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Card</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body> 
 
<div class="container mt-4 mb-4 p-4 border rounded shadow-lg mb-5 w-50 mx-auto overflow-hidden">
  <h2>{{ $service->service_name }}</h2>
  <div class="card">
    <div class="card-body">
      <p class="card-text">{{ $service->description }}</p>
      <p class="card-text">Price: {{ $service->price }}</p>
      <p class="card-text">Availability: {{ $service->availability }}</p>
      <p class="card-text">Category: {{ $service->category->category_name }}</p>
    </div>
  </div>
</div>

</body>
</html>
