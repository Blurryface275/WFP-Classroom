<h3 class="mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i>Update Article</h3>
@csrf
@method('PUT')

<div class="mb-3">
    <label for="edit_title" class="form-label fw-semibold">Title</label>
    <input type="text" name="edit_title" id="edit_title" class="form-control" value="{{ $data->title }}" required>
</div>

<div class="mb-3">
    <label for="edit_content" class="form-label fw-semibold">Content</label>
    <textarea name="edit_content" id="edit_content" rows="4" class="form-control" required>{{ $data->content }}</textarea>
</div>

<div class="mb-3">
    <label for="edit_photo" class="form-label fw-semibold">Photo URL</label>
    <input type="text" name="edit_photo" id="edit_photo" class="form-control" value="{{ $data->photo }}" required>
</div>

<div class="mb-4">
    <label for="edit_category_id" class="form-label fw-semibold">Kategori</label>
    <select name="edit_category_id" id="edit_category_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-success">Simpan Perubahan</button>
</div>
