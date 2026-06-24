<h3 class="mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i>Update Doctor</h3>
@csrf
@method('PUT')

<div class="mb-3">
    <label for="edit_name" class="form-label fw-semibold">Name</label>
    <input type="text" name="edit_name" id="edit_name" class="form-control" value="{{ $data->name }}" required>
</div>

<div class="mb-3">
    <label for="edit_email" class="form-label fw-semibold">Email</label>
    <input type="email" name="edit_email" id="edit_email" class="form-control" value="{{ $data->email }}" required>
</div>

<div class="mb-3">
    <label for="edit_phone" class="form-label fw-semibold">Phone</label>
    <input type="text" name="edit_phone" id="edit_phone" class="form-control" value="{{ $data->phone }}" required>
</div>

<div class="mb-3">
    <label for="edit_address" class="form-label fw-semibold">Address</label>
    <input type="text" name="edit_address" id="edit_address" class="form-control" value="{{ $data->address }}" required>
</div>

<div class="mb-3">
    <label for="edit_description" class="form-label fw-semibold">Description</label>
    <textarea name="edit_description" id="edit_description" rows="3" class="form-control" required>{{ $data->description }}</textarea>
</div>

<div class="mb-3">
    <label for="edit_specialist" class="form-label fw-semibold">Specialist</label>
    <input type="text" name="edit_specialist" id="edit_specialist" class="form-control" value="{{ $data->specialist }}" required>
</div>

<div class="mb-3">
    <label for="edit_gender" class="form-label fw-semibold">Gender</label>
    <select name="edit_gender" id="edit_gender" class="form-select" required>
        <option value="Male" {{ $data->gender == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ $data->gender == 'Female' ? 'selected' : '' }}>Female</option>
    </select>
</div>

<div class="d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-success">Simpan Perubahan</button>
</div>
