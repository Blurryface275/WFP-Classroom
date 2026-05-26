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

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    <h5 class="mb-0">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Category Name --}}
                        <div class="mb-3">
                            <label for="category_name" class="form-label fw-semibold">Nama Kategori</label>
                            <input
                                type="text"
                                name="category_name"
                                id="category_name"
                                class="form-control @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name') }}"
                                placeholder="Contoh: Konsultasi Umum"
                            >
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Gambar Kategori <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/*"
                                onchange="previewImage(event)"
                            >
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            {{-- Image Preview --}}
                            <div id="imagePreviewContainer" class="mt-3 d-none">
                                <p class="mb-1 text-muted small">Preview:</p>
                                <img id="imagePreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-floppy-fill me-1"></i> Simpan Kategori
                            </button>
                            <a href="{{ route('category.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }
</script>
@endpush
