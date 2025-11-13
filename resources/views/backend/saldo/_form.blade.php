@csrf
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="nama">Nama Saldo</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                   value="{{ old('nama', $saldo->nama ?? '') }}" placeholder="Contoh: Kas Utama, Dana Acara, dll." required>
            @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="balance">Balance (Saldo Awal)</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance"
                       value="{{ old('balance', $saldo->balance ?? 0) }}" step="0.01" required>
            </div>
            @error('balance')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>