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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    <h5 class="mb-0">Tambah Service Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        {{-- Service Name --}}
                        <div class="mb-3">
                            <label for="service_name" class="form-label fw-semibold">Nama Service</label>
                            <input
                                type="text"
                                name="service_name"
                                id="service_name"
                                class="form-control @error('service_name') is-invalid @enderror"
                                value="{{ old('service_name') }}"
                                placeholder="Contoh: Konsultasi Dokter Umum"
                            >
                            @error('service_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Jelaskan detail layanan..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Availability --}}
                        <div class="mb-3">
                            <label for="availability" class="form-label fw-semibold">Ketersediaan</label>
                            <input
                                type="text"
                                name="availability"
                                id="availability"
                                class="form-control @error('availability') is-invalid @enderror"
                                value="{{ old('availability') }}"
                                placeholder="Contoh: Senin-Jumat, 08:00-17:00"
                            >
                            @error('availability')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}"
                                placeholder="Contoh: 150000"
                                min="0"
                                step="1000"
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category Combo Box --}}
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-semibold">Kategori</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-floppy-fill me-1"></i> Simpan Service
                            </button>
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">
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
