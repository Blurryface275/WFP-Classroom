@extends('layouts.adminlte4')
@section('content')

@push('modal')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endpush




<div class="container">
    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h2 class="mb-0">List of Categories</h2>
        <a href="{{ route('category.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kategori
        </a>
    </div>
    <p>The <a href="#" onclick="showInfo()">table</a> class adds basic styling (light padding and only horizontal dividers) to a table:</p>
    <div id="showinfo"></div>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Category Name</th>
        <th>List of Services</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>

            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#imageModal-{{ $category->id }}">
                Show
            </button></td>
            @push ('modals')
            <!-- Modal {{ $category->id }} -->
            <div class="modal fade" id="imageModal-{{ $category->id }}" tabindex="-1" aria-labelledby="imageModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="imageModalLabel">Gambar untuk {{$category->category_name}} </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <img src="{{ asset('storage/'.$category->image) }}" width="100%">
                    {{-- {{ $category->id }} - {{ $category->category_name }} --}}
                  </div>
                  {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> --}}
                </div>
              </div>
            </div>
            @endpush

            <td>{{ $category->category_name }}</td>
            <td>
                <ul>
                    @foreach ($category->services as $service)
                        <li>{{ $service->service_name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
        <a class="btn btn-warning" href="{{ route('category.edit', $category->id) }}">Edit</a>
        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure to delete {{ $category->category_name }} - {{ $category->id }}?')">
        </form>
      </td>

        </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection

@push("script")
<script>
    function showInfo() {
      $.ajax({
        type: 'POST',
        url: '{{ route("category.showInfo") }}',
        data: '_token=<?php echo csrf_token(); ?>',
        success: function(data) {
          $('#showinfo').html(data.msg);
        }
      });
    }
  </script>
@endpush

