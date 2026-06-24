<h3 class="mb-4 text-success"><i class="bi bi-pencil-square me-2"></i>Update Transaksi</h3>
@csrf
@method('PUT')

<div class="mb-3">
    <label for="edit_service_id" class="form-label fw-semibold">Pilih Service</label>
    <select name="edit_service_id" id="edit_service_id" class="form-select">
        <option value="">-- Pilih Service --</option>
        @foreach ($services as $service)
            <option value="{{ $service->id }}" {{ $data->services->contains($service->id) ? 'selected' : '' }}>
                {{ $service->service_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="edit_transaction_date" class="form-label fw-semibold">Tanggal Transaksi</label>
    <input type="date" name="edit_transaction_date" id="edit_transaction_date" class="form-control" value="{{ $data->transaction_date }}">
</div>

<div class="mb-3">
    <label for="edit_status" class="form-label fw-semibold">Status</label>
    <select name="edit_status" id="edit_status" class="form-select">
        <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed" {{ $data->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="completed" {{ $data->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</div>

<div class="mb-3">
    <label for="edit_total_price" class="form-label fw-semibold">Total Harga (Rp)</label>
    <input type="number" name="edit_total_price" id="edit_total_price" class="form-control" value="{{ $data->total_price }}" min="0" step="1000">
</div>

<div class="mb-4">
    <label for="edit_payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
    <select name="edit_payment_method" id="edit_payment_method" class="form-select">
        <option value="cash" {{ $data->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="transfer" {{ $data->payment_method == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
        <option value="e-wallet" {{ $data->payment_method == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
        <option value="kartu_kredit" {{ $data->payment_method == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
    </select>
</div>

<div class="d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-success">Simpan Perubahan</button>
</div>
