@extends('backend.layouts.app')

@section('title', 'Edit Notulen')
@section('page-heading', 'Edit Notulen')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Notulen</h3>
                <p class="text-subtitle text-muted">Perbarui data notulen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.notulen.index') }}">Daftar Notulen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Notulen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <form action="{{ route('backend.notulen.update', $notulen->id) }}" method="POST" enctype="multipart/form-data" id="notulenForm">
            @csrf
            @method('PUT')

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
                                   id="judul_rapat" name="judul_rapat" value="{{ old('judul_rapat', $notulen->judul_rapat) }}" 
                                   placeholder="Contoh: Rapat Koordinasi HIMASI" required>
                            @error('judul_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipe_rapat" class="form-label">Tipe Rapat <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipe_rapat') is-invalid @enderror" 
                                    id="tipe_rapat" name="tipe_rapat" required>
                                <option value="" disabled>-- Pilih Tipe Rapat --</option>
                                @foreach(['Rutin','Koordinasi','Evaluasi','Perencanaan','Lainnya'] as $t)
                                    <option value="{{ $t }}" {{ old('tipe_rapat', $notulen->tipe_rapat) == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('tipe_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_rapat" class="form-label">Tanggal Rapat <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_rapat') is-invalid @enderror" 
                                   id="tanggal_rapat" name="tanggal_rapat" value="{{ old('tanggal_rapat', $notulen->tanggal_rapat->format('Y-m-d')) }}" required>
                            @error('tanggal_rapat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $notulen->waktu_mulai) }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $notulen->waktu_selesai) }}">
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" value="{{ old('lokasi', $notulen->lokasi) }}" 
                                   placeholder="Tempat pelaksanaan rapat" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pimpinan_rapat" class="form-label">Pimpinan Rapat <span class="text-danger">*</span></label>
                            <select class="form-select @error('pimpinan_rapat') is-invalid @enderror" 
                                    id="pimpinan_rapat" name="pimpinan_rapat" required>
                                <option value="" disabled>-- Pilih Pimpinan Rapat --</option>
                                @foreach($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('pimpinan_rapat', $notulen->pimpinan_rapat_id) == $item->id ? 'selected' : '' }}>
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
                                <option value="" disabled>-- Pilih Notulis --</option>
                                @foreach($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('notulis_id', $notulen->notulis_id) == $item->id ? 'selected' : '' }}>
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
                        @php $agendaOld = old('agenda'); @endphp
                        @if($agendaOld)
                            @foreach($agendaOld as $index => $item)
                                <div class="agenda-item card mb-3" data-index="{{ $index }}">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pembahasan <span class="text-danger">*</span></label>
                                            <textarea class="form-control tiny-editor" name="agenda[{{ $index }}][pembahasan]" required>{{ $item['pembahasan'] ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="agenda[{{ $index }}][keputusan]" value="{{ $item['keputusan'] ?? '' }}" required>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger removeAgendaBtn">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($notulen->agenda as $index => $a)
                                <div class="agenda-item card mb-3" data-index="{{ $index }}">
                                    <div class="card-body">
                                        <input type="hidden" name="agenda[{{ $index }}][id]" value="{{ $a->id }}">
                                        <div class="mb-3">
                                            <label class="form-label">Pembahasan <span class="text-danger">*</span></label>
                                            <textarea class="form-control tiny-editor" name="agenda[{{ $index }}][pembahasan]" required>{!! old('agenda.' . $index . '.pembahasan', $a->hasil_pembahasan) !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="agenda[{{ $index }}][keputusan]" value="{{ old('agenda.' . $index . '.keputusan', $a->status) }}" required>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger removeAgendaBtn">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <p class="text-muted small" id="noAgendaText" style="display: none;">Belum ada agenda. Klik tombol "Tambah Agenda" untuk menambahkan.</p>
                </div>
            </div>

            <!-- Kehadiran (Attendees) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Kehadiran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> Pilih anggota yang hadir dalam rapat ini
                    </div>
                    <div class="row">
                        @forelse($anggota as $item)
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="anggota{{ $item->id }}" 
                                           name="attendees[]" 
                                           value="{{ $item->id }}"
                                           {{ in_array(optional($item->users)->nama, $existingAttendees ?? []) || (is_array(old('attendees', [])) && in_array($item->id, old('attendees', []))) ? 'checked' : '' }}>
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

            <!-- Catatan Rapat -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Catatan Rapat</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="catatan_tambahan" class="form-label">Catatan Umum <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan_tambahan" name="catatan_tambahan" rows="4">{{ old('catatan_tambahan', $notulen->catatan_tambahan) }}</textarea>
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
                        <label for="dokumentasi" class="form-label">Upload Foto/Dokumen (tambahkan saja, file lama tetap ada)</label>
                        <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" id="dokumentasi" name="dokumentasi[]" multiple accept="image/*,.pdf,.doc,.docx">
                        <small class="form-text text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Maks 5 file)</small>
                        @error('dokumentasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($notulen->dokumentasi->count())
                            <hr>
                            <div class="row">
                                @foreach($notulen->dokumentasi as $doc)
                                    <div class="col-md-3 text-center mb-2">
                                        @if($doc->tipe == 'image')
                                            <img src="{{ asset('storage/' . $doc->path) }}" class="img-fluid rounded" alt="doc">
                                        @else
                                            <i class="bi bi-file-earmark-text" style="font-size: 36px;"></i>
                                            <div class="small">{{ basename($doc->path) }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
                        <i class="bi bi-check"></i> Perbarui Notulen
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
    tinymce.init({
        selector: '.tiny-editor',
        menubar: false,
        toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | link blockquote',
        plugins: 'link lists',
        height: 200,
        content_style: "body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 14px; }",
        setup: function(editor) {
            editor.on('change', function() { tinymce.triggerSave(); });
        }
    });

    let agendaCount = {{ $notulen->agenda->count() }};

    document.getElementById('addAgendaBtn').addEventListener('click', function() {
        const container = document.getElementById('agendaContainer');
        const agendaItem = document.createElement('div');
        agendaItem.className = 'agenda-item card mb-3';
        agendaItem.dataset.index = agendaCount;
        agendaItem.innerHTML = `
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pembahasan <span class="text-danger">*</span></label>
                    <textarea class="form-control tiny-editor-new" name="agenda[${agendaCount}][pembahasan]" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="agenda[${agendaCount}][keputusan]" placeholder="Keputusan yang diambil" required>
                </div>
                <button type="button" class="btn btn-sm btn-danger removeAgendaBtn">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        `;
        container.appendChild(agendaItem);

        const newTextarea = agendaItem.querySelector('.tiny-editor-new');
        newTextarea.classList.remove('tiny-editor-new');
        newTextarea.classList.add('tiny-editor');

        tinymce.init({ selector: '.tiny-editor', menubar:false, toolbar: 'undo redo | bold italic underline | bullist numlist | link', plugins: 'link lists', height:200 });
        agendaCount++;
        agendaItem.querySelector('.removeAgendaBtn').addEventListener('click', function(e){ e.target.closest('.agenda-item').remove(); updateNoAgendaText(); });
        updateNoAgendaText();
    });

    document.querySelectorAll('.removeAgendaBtn').forEach(btn => btn.addEventListener('click', function(e){ e.target.closest('.agenda-item').remove(); updateNoAgendaText(); }));

    function updateNoAgendaText(){ const items = document.getElementById('agendaContainer').querySelectorAll('.agenda-item'); document.getElementById('noAgendaText').style.display = items.length === 0 ? 'block' : 'none'; }
    updateNoAgendaText();
</script>
@endpush
