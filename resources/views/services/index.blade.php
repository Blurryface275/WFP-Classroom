@extends('layouts.adminlte4')
@section('content')
<div class="container-fluid py-4">
  {{-- Flash Message Success --}}
  @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0"><i class="bi bi-grid-fill me-2"></i>Services</h4>
      <a href="{{ route('services.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-circle-fill me-1"></i> Add New Service
      </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Service Name</th>
            <th>Description</th>
            <th>Availability</th>
            <th>Price</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td><a href="{{ route('services.show', $service->id) }}">{{ $service->service_name }}</a></td>
                <td>{{ $service->description }}</td>
                <td>{{ $service->availability }}</td>
                <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td>{{ $service->category->category_name }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

