@extends('backend.layouts.app')

@section('title', 'Daftar Notulen')
@section('page-heading', 'Daftar Notulen')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Notulen</h3>
                <p class="text-subtitle text-muted">Pantau catatan dan poin tindak lanjut dari setiap rapat.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Notulen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        {{-- Tombol Aksi & Search --}}
        <div class="mb-3 d-flex gap-2 align-items-center">
            <a href="{{ route('backend.notulen.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Notulen
            </a>
            <a href="{{ route('backend.notulen.archive') }}" class="btn btn-danger">
                <i class="bi bi-archive-fill"></i> Arsip
            </a>
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari judul atau catatan..." value="{{ request('q') }}">
                {{-- Preserve filter and sort params --}}
                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                <input type="hidden" name="order" value="{{ request('order') }}">
                <input type="hidden" name="tipe_rapat" value="{{ request('tipe_rapat') }}">
                <input type="hidden" name="pimpinan" value="{{ request('pimpinan') }}">
                <input type="hidden" name="notulis" value="{{ request('notulis') }}">
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Notulen Aktif</h5>

                    <div class="d-flex align-items-center gap-2">
                        <form method="GET" id="sortForm" class="d-flex align-items-center">
                            <select name="sort_by" class="form-select form-select-sm me-2" onchange="document.getElementById('sortForm').submit()">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                                <option value="tanggal_rapat" {{ request('sort_by') == 'tanggal_rapat' ? 'selected' : '' }}>Urutkan: Tanggal Rapat</option>
                                <option value="tipe_rapat" {{ request('sort_by') == 'tipe_rapat' ? 'selected' : '' }}>Urutkan: Tipe Rapat</option>
                            </select>
                            {{-- Toggle order button (arrow icon) --}}
                            <button type="submit" name="order" value="{{ request('order') == 'asc' ? 'desc' : 'asc' }}" class="btn btn-sm btn-outline-secondary" title="Toggle sort direction">
                                <i class="bi {{ request('order') == 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                            </button>
                            {{-- Preserve other query params when sorting --}}
                            @foreach(request()->except(['sort_by','order','page']) as $k => $v)
                                @if(is_array($v))
                                    @foreach($v as $vv)
                                        <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}" />
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                                @endif
                            @endforeach
                        </form>

                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>

                {{-- Active filters badges --}}
                <div class="mt-2">
                    @if(request()->filled('tipe_rapat'))
                        <span class="badge bg-primary">Tipe: {{ request('tipe_rapat') }}</span>
                    @endif
                    @if(request()->filled('pimpinan'))
                        @php $p = $anggota->firstWhere('id', request('pimpinan')); @endphp
                        <span class="badge bg-success">Pimpinan: {{ $p?->nama ?? request('pimpinan') }}</span>
                    @endif
                    @if(request()->filled('notulis'))
                        @php $n = $anggota->firstWhere('id', request('notulis')); @endphp
                        <span class="badge bg-warning text-dark">Notulis: {{ $n?->nama ?? request('notulis') }}</span>
                    @endif
                    @if(request()->filled('date_from') || request()->filled('date_to'))
                        <span class="badge bg-secondary">Tanggal: {{ request('date_from') ?? '-' }} — {{ request('date_to') ?? '-' }}</span>
                    @endif
                    @if(request()->query())
                        <a href="{{ route('backend.notulen.index') }}" class="badge bg-danger text-white ms-2">Reset</a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                @if($notulen->count())
                    <div class="list-group">
                        @foreach($notulen as $item)
                            <div class="list-group-item list-group-item-action border-bottom py-3">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <a href="{{ route('backend.notulen.show', $item->id) }}" class="flex-grow-1 text-decoration-none">
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="bi bi-file-earmark-text me-3 text-muted fs-4"></i>
                                            <div>
                                                <h6 class="mb-0 fw-600">{{ $item->judul_rapat ?? $item->judul }}</h6>
                                                <div class="text-muted small mt-1">
                                                    <span>
                                                        <i class="bi bi-calendar-event"></i>
                                                        {{ $item->tanggal_rapat ? \Carbon\Carbon::parse($item->tanggal_rapat)->format('d M Y') : '-' }}
                                                    </span>
                                                    <span class="ms-3">
                                                        <i class="bi bi-tag"></i>
                                                        {{ $item->tipe_rapat ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="text-end ms-3">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('backend.notulen.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Notulen">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteNotulen({{ $item->id }}, {!! json_encode($item->judul_rapat ?? $item->judul) !!})" title="Hapus Notulen">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                {{ $item->created_at->format('M d, Y') }}<br>
                                                {{ $item->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notulen->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada data notulen</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Notulen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus notulen "<span id="deleteItemTitle"></span>"?</p>
                <p class="text-warning mb-0"><small><i class="bi bi-exclamation-triangle"></i> Notulen akan dipindahkan ke arsip dan dapat dipulihkan kemudian.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

            <!-- Filter Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filter Notulen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="GET" action="{{ route('backend.notulen.index') }}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipe Rapat</label>
                                        <select name="tipe_rapat" class="form-select">
                                            <option value="">-- Semua --</option>
                                            @foreach(['Rutin','Koordinasi','Evaluasi','Perencanaan','Lainnya'] as $t)
                                                <option value="{{ $t }}" {{ request('tipe_rapat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Notulis</label>
                                        <select name="notulis" class="form-select">
                                            <option value="">-- Semua --</option>
                                            @foreach($anggota as $a)
                                                <option value="{{ $a->id }}" {{ request('notulis') == $a->id ? 'selected' : '' }}>{{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Dari</label>
                                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Sampai</label>
                                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                {{-- Preserve sorting params when filtering --}}
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                <input type="hidden" name="order" value="{{ request('order') }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<script>
    let deleteId = null;

    function deleteNotulen(id, title) {
        deleteId = id;
        document.getElementById('deleteItemTitle').textContent = title;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/backend/notulen/' + deleteId;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });

    document.getElementById('btnSort')?.addEventListener('click', function() {
        // Implementasi sorting logic
        alert('Sorting feature');
    });

    document.getElementById('btnFilter')?.addEventListener('click', function() {
        // Implementasi filter logic
        alert('Filter feature');
    });
</script>
@endpush
