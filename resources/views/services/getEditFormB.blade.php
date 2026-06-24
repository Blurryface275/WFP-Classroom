<h3 class="mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i>Update Service</h3>
@csrf
@method('PUT')

<div class="mb-3">
    <label for="edit_service_name" class="form-label fw-semibold">Nama Service</label>
    <input
        type="text"
        name="edit_service_name"
        id="edit_service_name"
        class="form-control"
        value="{{ $data->service_name }}"
    >
</div>

<div class="mb-3">
    <label for="edit_description" class="form-label fw-semibold">Deskripsi</label>
    <textarea
        name="edit_description"
        id="edit_description"
        rows="3"
        class="form-control"
    >{{ $data->description }}</textarea>
</div>

<div class="mb-3">
    <label for="edit_availability" class="form-label fw-semibold">Ketersediaan</label>
    <input
        type="text"
        name="edit_availability"
        id="edit_availability"
        class="form-control"
        value="{{ $data->availability }}"
    >
</div>

<div class="mb-3">
    <label for="edit_price" class="form-label fw-semibold">Harga (Rp)</label>
    <input
        type="number"
        name="edit_price"
        id="edit_price"
        class="form-control"
        value="{{ $data->price }}"
        min="0"
        step="1000"
    >
</div>

<div class="mb-4">
    <label for="edit_category_id" class="form-label fw-semibold">Kategori</label>
    <select
        name="edit_category_id"
        id="edit_category_id"
        class="form-select"
    >
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <i class="bi bi-x-circle me-1"></i> Batal
    </button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-success">
        <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan
    </button>
</div>
