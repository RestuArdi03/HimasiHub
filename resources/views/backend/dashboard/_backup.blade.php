@can('access-backup') {{-- Direktif Blade untuk kontrol akses --}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Database</h5>
    </div>
    <div class="card-body">
        <p>Simpan atau pulihkan seluruh data aplikasi.</p>
        <!-- Tombol untuk memicu modal backup -->
        <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#backupModal">
            <i class="bi bi-download"></i> Backup
        </button>
        <!-- Tombol untuk memicu modal restore -->
        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#restoreModal">
            <i class="bi bi-upload"></i> Restore
        </button>
    </div>
</div>
@endcan