<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-warning">
            <h5 class="modal-title">
                <i class="bi bi-pencil-square me-2"></i>Edit Kategori
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ route('category.update', $data->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_name" class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text" class="form-control" id="category_name" name="category_name"
                        placeholder="Enter Category Name" value="{{ $data->category_name }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-floppy-fill me-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>