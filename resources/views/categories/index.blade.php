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
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h2 class="mb-0">List of Categories</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('category.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kategori
            </a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#btnFormModal">
                + New Category (with Modals)
            </button>
        </div>
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
        <a class="btn btn-warning" href="{{ route('category.edit', $category->id) }}"><i class="bi bi-pencil-square"></i>Edit</a>

        <a href="#modalEditA" class="btn btn-warning" data-bs-toggle="modal" onclick="getEditForm({{ $category->id }})"><i class="bi pencil"></i>Edit</a>
        {{-- Hidden delete form (outside modal) --}}
        <form id="delete-form-{{ $category->id }}"
              action="{{ route('category.destroy', $category->id) }}"
              method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
        </form>

        {{-- Trigger button --}}
        <button type="button" class="btn btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#deleteModal-{{ $category->id }}">
            Delete
        </button>

        @push('modals')
        <!-- Delete Confirmation Modal {{ $category->id }} -->
        <div class="modal fade" id="deleteModal-{{ $category->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Hapus Kategori {{ $category->category_name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus kategori <strong>{{ $category->category_name }}</strong> (ID: {{ $category->id }})?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger"
                        onclick="document.getElementById('delete-form-{{ $category->id }}').submit()">
                    Yes, Hapus
                </button>
              </div>
            </div>
          </div>
        </div>
        @endpush
      </td>

        </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('modals')
<div class="modal fade" id="btnFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label for="modal_category_name" class="form-label fw-semibold">Nama Kategori</label>
                        <input
                            type="text"
                            name="category_name"
                            id="modal_category_name"
                            class="form-control @error('category_name') is-invalid @enderror"
                            value="{{ old('category_name') }}"
                            placeholder="Contoh: Konsultasi Umum"
                        >
                        @error('category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-3">
                        <label for="modal_image" class="form-label fw-semibold">
                            Gambar Kategori <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="modal_image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*"
                            onchange="previewModalImage(event)"
                        >
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        {{-- Image Preview --}}
                        <div id="modalImagePreviewContainer" class="mt-3 d-none">
                            <p class="mb-1 text-muted small">Preview:</p>
                            <img id="modalImagePreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bg-danger border-danger text-white" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-floppy-fill me-1"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditA" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog modal-wide">
       <div class="modal-content" >
          <div class="modal-body" id="modalContent">
              {{-- You can put animated loading image here... --}}
              <div class="text-center p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat data...</p>
            </div>
          </div>
       </div>
   </div>
</div> 
@endpush

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

    function previewModalImage(event) {
        const file = event.target.files[0];
        const container = document.getElementById('modalImagePreviewContainer');
        const preview = document.getElementById('modalImagePreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }
    function getEditForm(id) {
       $.ajax({
                    type: 'POST',
                    url: '{{ route('category.getEditForm') }}',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': id
                    },
                    success: function(data) {
                        $('#modalEditA').html(data.msg)
                    }
                });
    }
</script>
@endpush

