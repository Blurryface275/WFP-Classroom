@extends('layouts.adminlte4')
@section('content')

<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i>Daftar Doctor</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateDoctor">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Doctor Baru (Modal)
        </button>
    </div>

    @push('modals')
    <!-- Modal Create Doctor -->
    <div class="modal fade" id="modalCreateDoctor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Doctor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('doctor.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="specialist" class="form-label fw-semibold">Specialist</label>
                            <input type="text" name="specialist" id="specialist" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill me-1"></i> Simpan Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush

    <div class="card shadow-sm">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0 text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Specialist</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                    <tr id="tr_{{ $doctor->id }}">
                        <td>{{ $doctor->id }}</td>
                        <td id="td_name_{{ $doctor->id }}">{{ $doctor->name }}</td>
                        <td id="td_email_{{ $doctor->id }}">{{ $doctor->email }}</td>
                        <td id="td_phone_{{ $doctor->id }}">{{ $doctor->phone }}</td>
                        <td id="td_address_{{ $doctor->id }}">{{ $doctor->address }}</td>
                        <td id="td_specialist_{{ $doctor->id }}">{{ $doctor->specialist }}</td>
                        <td id="td_gender_{{ $doctor->id }}">{{ $doctor->gender }}</td>
                        <td>
                            <a href="#modalEditB" class="btn btn-sm btn-primary" data-bs-toggle="modal" onclick="getEditFormB({{ $doctor->id }})">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete Doctor: {{ $doctor->name }}?')) deleteDataRemove({{ $doctor->id }})">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada Doctor.
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
            url: '{{ route('doctors.getEditFormB') }}',
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
        var name = $('#edit_name').val();
        var email = $('#edit_email').val();
        var phone = $('#edit_phone').val();
        var address = $('#edit_address').val();
        var description = $('#edit_description').val();
        var specialist = $('#edit_specialist').val();
        var gender = $('#edit_gender').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('doctors.saveDataUpdate') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'name': name,
                'email': email,
                'phone': phone,
                'address': address,
                'description': description,
                'specialist': specialist,
                'gender': gender
            },
            success: function(data) {
                if (data.status == "oke") {
                    if (typeof showAjaxNotification === "function") showAjaxNotification(data.msg);
                    $('#td_name_' + id).html(name);
                    $('#td_email_' + id).html(email);
                    $('#td_phone_' + id).html(phone);
                    $('#td_address_' + id).html(address);
                    $('#td_specialist_' + id).html(specialist);
                    $('#td_gender_' + id).html(gender);
                    $('#modalEditB').modal('hide');
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('doctors.deleteData') }}',
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

