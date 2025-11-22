@extends('backend.layouts.app')

@section('title', 'Edit Publikasi')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Publikasi</h3>
                    <p class="text-subtitle text-muted">Ubah data konten publikasi melalui form di bawah.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.konten.index') }}">Publikasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Edit Publikasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.konten.update', $konten) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.konten._form', ['konten' => $konten])
                        <button type="submit" class="btn btn-primary me-1 mb-1">Perbarui</button>
                        <a href="{{ route('backend.konten.index') }}" class="btn btn-secondary me-1 mb-1">Batal</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    {{-- Summernote butuh jquery, jadi kita panggil dulu --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Mammoth.js untuk membaca file .docx --}}
    <script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#deskripsi').summernote({
                height: 300
            });

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    mammoth.convertToHtml({ arrayBuffer: e.target.result })
                        .then(function(result) {
                            $('#deskripsi').summernote('code', result.value);
                        })
                        .catch(function(err) {
                            console.log("Error reading docx file:", err);
                            alert("Gagal membaca file docx. Pastikan file tidak rusak.");
                        });
                };
                reader.readAsArrayBuffer(file);
            }

            $('#file_konten').on('change', handleFileSelect);

            // Toggle antara editor dan upload file
            $('input[name="content_source"]').on('change', function() {
                if (this.value === 'editor') {
                    $('#deskripsi').next('.note-editor').show();
                    $('#file-upload-container').hide();
                } else { // 'file'
                    $('#deskripsi').next('.note-editor').hide();
                    $('#file-upload-container').show();
                }
            });

            $('input[name="content_source"]:checked').trigger('change');
        });
    </script>
@endpush
