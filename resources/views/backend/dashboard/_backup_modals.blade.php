<!-- Modal Backup -->
<div class="modal fade" id="backupModal" tabindex="-1" aria-labelledby="backupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backupModalLabel">Konfirmasi Backup Database</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membuat file backup dari database saat ini? Proses ini mungkin memakan waktu beberapa saat.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('backend.backup.create') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-download"></i> Ya, Buat Backup
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Restore -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="restoreModalLabel">Konfirmasi Restore Database</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backend.backup.restore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">PERINGATAN!</h4>
                        <p>Tindakan ini akan <strong>MENGGANTI SELURUH DATA</strong> yang ada di database dengan data dari file backup yang Anda unggah. Semua perubahan setelah file backup dibuat akan hilang. <strong>Tindakan ini tidak dapat dibatalkan.</strong></p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="backup_file" class="form-label">Pilih File Backup (.zip)</label>
                        <input class="form-control" type="file" id="backup_file" name="backup_file" accept=".zip" required>
                    </div>
                    <p>Pastikan Anda telah memilih file backup yang benar sebelum melanjutkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-upload"></i> Ya, Saya Mengerti dan Ingin Restore
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>