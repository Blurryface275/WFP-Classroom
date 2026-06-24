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
        <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Daftar Article</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateArticle">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Article (Modal)
        </button>
    </div>

    @push('modals')
    <!-- Modal Create Article -->
    <div class="modal fade" id="modalCreateArticle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Article</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('article.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Judul artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label fw-semibold">Content</label>
                            <textarea name="content" id="content" rows="4" class="form-control" placeholder="Isi artikel..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label fw-semibold">Photo URL</label>
                            <input type="text" name="photo" id="photo" class="form-control" placeholder="Link gambar..." required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
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
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill me-1"></i> Simpan Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush

    <div class="card shadow-sm">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                    <tr id="tr_{{ $article->id }}">
                        <td>{{ $article->id }}</td>
                        <td id="td_title_{{ $article->id }}">{{ $article->title }}</td>
                        <td id="td_content_{{ $article->id }}">{{ Str::limit($article->content, 50) }}</td>
                        <td id="td_photo_{{ $article->id }}">{{ $article->photo }}</td>
                        <td id="td_category_{{ $article->id }}">{{ $article->category->category_name }}</td>
                        <td>
                            <a href="#modalEditB" class="btn btn-sm btn-primary" data-bs-toggle="modal" onclick="getEditFormB({{ $article->id }})">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete Article: {{ $article->title }}?')) deleteDataRemove({{ $article->id }})">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada Article.
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
            url: '{{ route('articles.getEditFormB') }}',
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
        var title = $('#edit_title').val();
        var content = $('#edit_content').val();
        var photo = $('#edit_photo').val();
        var category_id = $('#edit_category_id').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('articles.saveDataUpdate') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'title': title,
                'content': content,
                'photo': photo,
                'category_id': category_id
            },
            success: function(data) {
                if (data.status == "oke") {
                    if (typeof showAjaxNotification === "function") showAjaxNotification(data.msg);
                    $('#td_title_' + id).html(title);
                    $('#td_content_' + id).html(content.substring(0, 50) + (content.length > 50 ? '...' : ''));
                    $('#td_photo_' + id).html(photo);
                    $('#td_category_' + id).html(data.category_name);
                    $('#modalEditB').modal('hide');
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('articles.deleteData') }}',
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

