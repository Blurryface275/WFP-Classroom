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
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-receipt-cutoff me-2"></i>
                    <h5 class="mb-0">Buat Transaksi Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.store') }}" method="POST">
                        @csrf

                        {{-- Service Combo Box (Many-to-Many) --}}
                        <div class="mb-3">
                            <label for="service_id" class="form-label fw-semibold">
                                Pilih Service
                                <span class="badge bg-info ms-1">Many-to-Many</span>
                            </label>
                            <select
                                name="service_id"
                                id="service_id"
                                class="form-select @error('service_id') is-invalid @enderror"
                            >
                                <option value="">-- Pilih Service --</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->service_name }}
                                        (Rp {{ number_format($service->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Service yang dipilih akan dihubungkan ke transaksi ini melalui tabel pivot <code>service_transaction</code>.
                            </div>
                        </div>

                        {{-- Transaction Date --}}
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label fw-semibold">Tanggal Transaksi</label>
                            <input
                                type="date"
                                name="transaction_date"
                                id="transaction_date"
                                class="form-control @error('transaction_date') is-invalid @enderror"
                                value="{{ old('transaction_date', date('Y-m-d')) }}"
                            >
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                            >
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Price --}}
                        <div class="mb-3">
                            <label for="total_price" class="form-label fw-semibold">Total Harga (Rp)</label>
                            <input
                                type="number"
                                name="total_price"
                                id="total_price"
                                class="form-control @error('total_price') is-invalid @enderror"
                                value="{{ old('total_price') }}"
                                placeholder="Contoh: 250000"
                                min="0"
                                step="1000"
                            >
                            @error('total_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select
                                name="payment_method"
                                id="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror"
                            >
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="e-wallet" {{ old('payment_method') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="kartu_kredit" {{ old('payment_method') == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-floppy-fill me-1"></i> Simpan Transaksi
                            </button>
                            <a href="{{ route('transaction.index') }}" class="btn btn-secondary">
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
