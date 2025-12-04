@extends('backend.layouts.app')

@section('title', 'Tambah Publikasi')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Publikasi Baru</h3>
                    <p class="text-subtitle text-muted">Isi form di bawah untuk menambahkan konten publikasi baru.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.konten.index') }}">Publikasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Tambah Publikasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.konten.store') }}" method="POST" enctype="multipart/form-data">
                        @include('backend.konten._form')
                        <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        <a href="{{ route('backend.konten.index') }}" class="btn btn-secondary me-1 mb-1">Batal</a>
                    </form>
                </div>
            </div>
        </section>

        <!-- Modal Peringatan Ukuran File -->
        <div class="modal fade" id="size-warning-modal" tabindex="-1" role="dialog" aria-labelledby="sizeWarningModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sizeWarningModalLabel">Peringatan Ukuran File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ukuran file lebih dari 2MB. Proses konversi mungkin memakan waktu lama atau gagal. Apakah Anda ingin melanjutkan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel-upload-btn">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirm-upload-btn">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Error Konversi -->
        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="errorModalLabel">Gagal Membaca File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Gagal membaca file docx. Pastikan file tidak rusak dan dalam format yang benar.
                    </div>
                </div>
            </div>
        </div>
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

            let selectedFile = null;
            const sizeWarningModal = new bootstrap.Modal(document.getElementById('size-warning-modal'));
            const errorModal = new bootstrap.Modal(document.getElementById('error-modal'));

            function processFile(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    mammoth.convertToHtml({ arrayBuffer: e.target.result })
                        .then(function(result) {
                            $('#deskripsi').summernote('code', result.value);
                        })
                        .catch(function(err) {
                            console.log("Error reading docx file:", err);
                            errorModal.show();
                        });
                };
                reader.readAsArrayBuffer(file);
            }

            function handleFileSelect(event) {
                const file = event.target.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!file) {
                    selectedFile = null;
                    return;
                }

                selectedFile = file;

                if (file.size > maxSize) {
                    sizeWarningModal.show();
                } else {
                    processFile(selectedFile);
                }
            }

            $('#file_konten').on('change', handleFileSelect);
            $('#confirm-upload-btn').on('click', function() {
                if (selectedFile) {
                    processFile(selectedFile);
                }
                sizeWarningModal.hide();
            });
            $('#cancel-upload-btn').on('click', function() {
                $('#file_konten').val('');
                selectedFile = null;
            });

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
