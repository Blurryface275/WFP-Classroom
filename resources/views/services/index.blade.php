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
      <h4 class="mb-0"><i class="bi bi-grid-fill me-2"></i>Services</h4>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateService">
          <i class="bi bi-plus-circle-fill me-1"></i> Add New Service (Modal)
      </button>
  </div>

@push('modals')
<!-- Modal Create Service -->
<div class="modal fade" id="modalCreateService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Service Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="service_name" class="form-label fw-semibold">Nama Service</label>
                        <input type="text" name="service_name" id="service_name" class="form-control" placeholder="Contoh: Konsultasi Dokter Umum" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Jelaskan detail layanan..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="availability" class="form-label fw-semibold">Ketersediaan</label>
                        <input type="text" name="availability" id="availability" class="form-control" placeholder="Contoh: Senin-Jumat, 08:00-17:00" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Contoh: 150000" min="0" step="1000" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <!-- We need to pass $categories to the index view if we haven't already -->
                            @if(isset($categories))
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill me-1"></i> Simpan Service</button>
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
            <th>Service Name</th>
            <th>Description</th>
            <th>Availability</th>
            <th>Price</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr id="tr_{{ $service->id }}">
                <td>{{ $service->id }}</td>
                <td id="td_service_name_{{ $service->id }}"><a href="{{ route('services.show', $service->id) }}">{{ $service->service_name }}</a></td>
                <td id="td_description_{{ $service->id }}">{{ $service->description }}</td>
                <td id="td_availability_{{ $service->id }}">{{ $service->availability }}</td>
                <td id="td_price_{{ $service->id }}">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td id="td_category_name_{{ $service->id }}">{{ $service->category->category_name }}</td>
                <td>
                    <a href="#modalEditB" class="btn btn-sm btn-primary" data-bs-toggle="modal" onclick="getEditFormB({{ $service->id }})">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete {{ $service->id }} - {{ $service->service_name }}?')) deleteDataRemove({{ $service->id }})">
                        <i class="bi bi-trash"></i> Delete 
                    </a>
                </td>
            </tr>
            @endforeach
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
        // Show loading state while getting form
        $('#modalContentB').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3 text-muted">Memuat data...</p></div>');

        $.ajax({
            type: 'POST',
            url: '{{ route('services.getEditFormB') }}',
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
        var service_name = $('#edit_service_name').val();
        var description = $('#edit_description').val();
        var availability = $('#edit_availability').val();
        var price = $('#edit_price').val();
        var category_id = $('#edit_category_id').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('services.saveDataUpdate') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'service_name': service_name,
                'description': description,
                'availability': availability,
                'price': price,
                'category_id': category_id,
            },
            success: function(data) {
                if (data.status == "oke") {
                    if (typeof showAjaxNotification === "function") showAjaxNotification(data.msg);
                    // Update table UI
                    $('#td_service_name_' + id).html('<a href="{{ url('services') }}/' + id + '">' + service_name + '</a>');
                    $('#td_description_' + id).html(description);
                    $('#td_availability_' + id).html(availability);
                    // Format price rudimentarily mapping Rp
                    $('#td_price_' + id).html('Rp ' + new Intl.NumberFormat('id-ID').format(price));
                    $('#td_category_name_' + id).html(data.category_name);

                    $('#modalEditB').modal('hide');
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('services.deleteData') }}',
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


