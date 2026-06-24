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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreateTransaction">
            <i class="bi bi-plus-circle-fill me-1"></i> Buat Transaksi Baru (Modal)
        </button>
    </div>

    @push('modals')
    <!-- Modal Create Transaction -->
    <div class="modal fade" id="modalCreateTransaction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Buat Transaksi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transaction.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="service_id" class="form-label fw-semibold">Pilih Service</label>
                            <select name="service_id" id="service_id" class="form-select" required>
                                <option value="">-- Pilih Service --</option>
                                @if(isset($services))
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->service_name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label fw-semibold">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label fw-semibold">Total Harga (Rp)</label>
                            <input type="number" name="total_price" id="total_price" class="form-control" min="0" step="1000" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="e-wallet">E-Wallet</option>
                                <option value="kartu_kredit">Kartu Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-floppy-fill me-1"></i> Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush

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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr id="tr_{{ $transaction->id }}">
                        <td>{{ $transaction->id }}</td>
                        <td id="td_transaction_date_{{ $transaction->id }}">{{ $transaction->transaction_date }}</td>
                        <td id="td_status_{{ $transaction->id }}">
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
                        <td id="td_total_price_{{ $transaction->id }}">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td id="td_payment_method_{{ $transaction->id }}">{{ $transaction->payment_method }}</td>
                        <td id="td_services_{{ $transaction->id }}">
                            @foreach ($transaction->services as $service)
                                <span class="badge bg-info text-dark me-1">{{ $service->service_name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="#modalEditB" class="btn btn-sm btn-primary" data-bs-toggle="modal" onclick="getEditFormB({{ $transaction->id }})">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete Transaksi ID: {{ $transaction->id }}?')) deleteDataRemove({{ $transaction->id }})">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada transaksi.
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalCreateTransaction">Buat sekarang</button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('modals')
<!-- Modal Edit B -->
<div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="modalContentB">
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

@push('script')
<script>
    function getEditFormB(id) {
        $('#modalContentB').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3 text-muted">Memuat data...</p></div>');

        $.ajax({
            type: 'POST',
            url: '{{ route('transactions.getEditFormB') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg);
            }
        });
    }

    function saveDataUpdate(id) {
        var transaction_date = $('#edit_transaction_date').val();
        var status = $('#edit_status').val();
        var total_price = $('#edit_total_price').val();
        var payment_method = $('#edit_payment_method').val();
        var service_id = $('#edit_service_id').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('transactions.saveDataUpdate') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'transaction_date': transaction_date,
                'status': status,
                'total_price': total_price,
                'payment_method': payment_method,
                'service_id': service_id,
            },
            success: function(data) {
                if (data.status == "oke") {
                    if (typeof showAjaxNotification === "function") showAjaxNotification(data.msg);
                    $('#td_transaction_date_' + id).html(transaction_date);
                    
                    var badge = 'secondary';
                    if(status === 'completed') badge = 'success';
                    else if(status === 'confirmed') badge = 'primary';
                    else if(status === 'pending') badge = 'warning';
                    else if(status === 'cancelled') badge = 'danger';
                    
                    $('#td_status_' + id).html('<span class="badge bg-' + badge + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>');
                    $('#td_total_price_' + id).html('Rp ' + new Intl.NumberFormat('id-ID').format(total_price));
                    $('#td_payment_method_' + id).html(payment_method);
                    $('#td_services_' + id).html(data.services_html);

                    $('#modalEditB').modal('hide');
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('transactions.deleteData') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    if (typeof showAjaxNotification === "function") showAjaxNotification(data.msg);
                    $('#tr_' + id).remove();
                }
            }
        });
    }
</script>
@endpush
@endsection

