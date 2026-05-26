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
        <h4 class="mb-0"><i class="bi bi-receipt me-2"></i>Daftar Transaksi</h4>
        <a href="{{ route('transaction.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle-fill me-1"></i> Buat Transaksi Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Metode Bayar</th>
                        <th>Services</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->transaction_date }}</td>
                        <td>
                            @php
                                $badge = match($transaction->status) {
                                    'completed' => 'success',
                                    'confirmed' => 'primary',
                                    'pending'   => 'warning',
                                    'cancelled' => 'danger',
                                    default     => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($transaction->status) }}</span>
                        </td>
                        <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>{{ $transaction->payment_method }}</td>
                        <td>
                            @foreach ($transaction->services as $service)
                                <span class="badge bg-info text-dark">{{ $service->service_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada transaksi.
                            <a href="{{ route('transaction.create') }}">Buat sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
