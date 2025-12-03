@extends('backend.layouts.app')

@section('title', 'Tambah Notulen')
@section('page-heading', 'Tambah Notulen Baru')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Notulen Baru</h3>
                <p class="text-subtitle text-muted">Catat poin-poin penting dari rapat</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.notulen.index') }}">Daftar Notulen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Notulen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <form action="{{ route('backend.notulen.store') }}" method="POST" enctype="multipart/form-data" id="notulenForm">

    <section class="section">
        <form action="{{ route('backend.notulen.store') }}" method="POST" enctype="multipart/form-data" id="notulenForm">
            @csrf

            <!-- Informasi Rapat -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Rapat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="judul_rapat" class="form-label">Judul Rapat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul_rapat') is-invalid @enderror" 
                                   id="judul_rapat" name="judul_rapat" value="{{ old('judul_rapat') }}" 
                                   placeholder="Contoh: Rapat Koordinasi HIMASI" required>
                            @error('judul_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipe_rapat" class="form-label">Tipe Rapat <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipe_rapat') is-invalid @enderror" 
                                    id="tipe_rapat" name="tipe_rapat" required>
                                <option value="" selected disabled>-- Pilih Tipe Rapat --</option>
                                <option value="Rutin" {{ old('tipe_rapat') == 'Rutin' ? 'selected' : '' }}>Rutin</option>
                                <option value="Koordinasi" {{ old('tipe_rapat') == 'Koordinasi' ? 'selected' : '' }}>Koordinasi</option>
                                <option value="Evaluasi" {{ old('tipe_rapat') == 'Evaluasi' ? 'selected' : '' }}>Evaluasi</option>
                                <option value="Perencanaan" {{ old('tipe_rapat') == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                                <option value="Lainnya" {{ old('tipe_rapat') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('tipe_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_rapat" class="form-label">Tanggal Rapat <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_rapat') is-invalid @enderror" 
                                   id="tanggal_rapat" name="tanggal_rapat" value="{{ old('tanggal_rapat', now()->format('Y-m-d')) }}" required>
                            @error('tanggal_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}">
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" value="{{ old('lokasi') }}" 
                                   placeholder="Tempat pelaksanaan rapat" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pimpinan_rapat" class="form-label">Pimpinan Rapat <span class="text-danger">*</span></label>
                            <select class="form-select @error('pimpinan_rapat') is-invalid @enderror" 
                                    id="pimpinan_rapat" name="pimpinan_rapat" required>
                                <option value="" selected disabled>-- Pilih Pimpinan Rapat --</option>
                                @foreach($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('pimpinan_rapat') == $item->id ? 'selected' : '' }}>
                                        {{ optional($item->users)->nama }} @if(optional($item->jabatan)->nama_jabatan) ({{ optional($item->jabatan)->nama_jabatan }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('pimpinan_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="notulis_id" class="form-label">Notulis <span class="text-danger">*</span></label>
                            <select class="form-select @error('notulis_id') is-invalid @enderror" 
                                    id="notulis_id" name="notulis_id" required>
                                <option value="" selected disabled>-- Pilih Notulis --</option>
                                @foreach($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('notulis_id') == $item->id ? 'selected' : '' }}>
                                        {{ optional($item->users)->nama }} @if(optional($item->jabatan)->nama_jabatan) ({{ optional($item->jabatan)->nama_jabatan }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('notulis_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda & Pembahasan -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Agenda & Pembahasan</h5>
                    <button type="button" class="btn btn-sm btn-primary" id="addAgendaBtn">
                        <i class="bi bi-plus"></i> Tambah Agenda
                    </button>
                </div>
                <div class="card-body">
                    <div id="agendaContainer">
                        @if(old('agenda'))
                            @foreach(old('agenda') as $index => $item)
                                <div class="agenda-item card mb-3" data-index="{{ $index }}">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pembahasan <span class="text-danger">*</span></label>
                                            <textarea class="form-control tiny-editor" 
                                                      name="agenda[{{ $index }}][pembahasan]" required>{{ $item['pembahasan'] ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="agenda[{{ $index }}][keputusan]" 
                                                   value="{{ $item['keputusan'] ?? '' }}" placeholder="Keputusan yang diambil" required>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger removeAgendaBtn">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <p class="text-muted small" id="noAgendaText" style="display: none;">
                        Belum ada agenda. Klik tombol "Tambah Agenda" untuk menambahkan.
                    </p>
                </div>
            </div>

            <!-- (Catatan Rapat dipindah ke bawah sebelum Dokumentasi) -->

            <!-- Kehadiran (Attendees) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Kehadiran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> 
                        Pilih anggota yang hadir dalam rapat ini
                    </div>
                    <div class="row">
                        @forelse($anggota as $item)
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="anggota{{ $item->id }}" 
                                           name="attendees[]" 
                                           value="{{ $item->id }}"
                                           @if(old('attendees') && in_array($item->id, old('attendees'))) checked @endif>
                                    <label class="form-check-label" for="anggota{{ $item->id }}">
                                        {{ optional($item->users)->nama }} ({{ optional($item->jabatan)->nama_jabatan ?? '-' }})
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Belum ada anggota yang terdaftar</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

                    <!-- Catatan Rapat (ditempatkan sebelum Dokumentasi) -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Catatan Rapat</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="catatan_tambahan" class="form-label">Catatan Umum <span class="text-danger">*</span></label>
                                <textarea class="form-control" 
                                          id="catatan_tambahan" name="catatan_tambahan" rows="4">{{ old('catatan_tambahan') }}</textarea>
                                @error('catatan_tambahan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dokumentasi (Opsional)</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">Upload Foto/Dokumen</label>
                        <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" 
                               id="dokumentasi" name="dokumentasi[]" multiple accept="image/*,.pdf,.doc,.docx">
                        <small class="form-text text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Maks 5 file)</small>
                        @error('dokumentasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('backend.notulen.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Notulen
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<!-- TinyMCE (local vendor to avoid cloud API warning) -->
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script>
    // Initialize TinyMCE on page load
    tinymce.init({
        selector: '.tiny-editor',
        menubar: false,
        toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | link blockquote',
        plugins: 'link lists',
        height: 200,
        content_style: "body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 14px; }",
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });

    let agendaCount = {{ count(old('agenda', [])) }};

    // Tambah Agenda
    document.getElementById('addAgendaBtn').addEventListener('click', function() {
        const container = document.getElementById('agendaContainer');
        const agendaItem = document.createElement('div');
        agendaItem.className = 'agenda-item card mb-3';
        agendaItem.dataset.index = agendaCount;
        agendaItem.innerHTML = `
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pembahasan <span class="text-danger">*</span></label>
                    <textarea class="form-control tiny-editor-new" 
                              name="agenda[${agendaCount}][pembahasan]" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="agenda[${agendaCount}][keputusan]" 
                           placeholder="Keputusan yang diambil" required>
                </div>
                <button type="button" class="btn btn-sm btn-danger removeAgendaBtn">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        `;
        container.appendChild(agendaItem);
        
        // Initialize TinyMCE for new textarea
        const newTextarea = agendaItem.querySelector('.tiny-editor-new');
        newTextarea.classList.remove('tiny-editor-new');
        newTextarea.classList.add('tiny-editor');
        
        tinymce.init({
            selector: '#' + newTextarea.id || 'textarea[name="agenda[' + agendaCount + '][pembahasan]"]',
            menubar: false,
            toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | link blockquote',
            plugins: 'link lists',
            height: 200,
            content_style: "body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 14px; }",
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
        
        agendaCount++;
        
        // Attach remove event
        agendaItem.querySelector('.removeAgendaBtn').addEventListener('click', removeAgenda);
        updateNoAgendaText();
    });

    // Hapus Agenda
    function removeAgenda(e) {
        const agendaItem = e.target.closest('.agenda-item');
        const editors = agendaItem.querySelectorAll('.tiny-editor');
        
        // Remove TinyMCE instances
        editors.forEach(editor => {
            const instance = tinymce.get(editor.id);
            if (instance) {
                instance.remove();
            }
        });
        
        agendaItem.remove();
        updateNoAgendaText();
    }

    // Event listeners untuk tombol remove yang sudah ada
    document.querySelectorAll('.removeAgendaBtn').forEach(btn => {
        btn.addEventListener('click', removeAgenda);
    });

    function updateNoAgendaText() {
        const container = document.getElementById('agendaContainer');
        const items = container.querySelectorAll('.agenda-item');
        document.getElementById('noAgendaText').style.display = items.length === 0 ? 'block' : 'none';
    }

    // Inisialisasi
    updateNoAgendaText();
</script>
@endpush
