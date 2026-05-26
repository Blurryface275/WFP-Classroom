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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

  <h2>List of Categories</h2>
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

