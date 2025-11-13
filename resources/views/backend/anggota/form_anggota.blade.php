@csrf
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                   value="{{ old('nama', $anggota->nama ?? '') }}" placeholder="Masukkan nama lengkap anggota" required>
            @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim"
                   value="{{ old('nim', $anggota->nim ?? '') }}" placeholder="Masukkan NIM anggota" required>
            @error('nim')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="kelas">Kelas</label>
        <fieldset class="form-group">
            <select class="form-select" id="kelas" name="kelas" required>
                <option value="" disabled selected>Pilih Kelas</option>
                <option value="19.1A.09">19.1A.09</option>
                <option value="19.2A.09">19.2A.09</option>
                <option value="19.3A.09">19.3A.09</option>
                <option value="19.4A.09">19.4A.09</option>
                <option value="19.5A.09">19.5A.09</option>
            </select>
        </fieldset>
        @error('kelas')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="jurusan">Jurusan</label>
        <fieldset class="form-group">
            <select class="form-select" id="jurusan" name="jurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
            </select>
        </fieldset>
        @error('jurusan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
                   value="{{ old('no_hp', $anggota->no_hp ?? '') }}" placeholder="Masukkan No HP anggota">
            @error('no_hp')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="jabatan">Jabatan</label>
        <fieldset class="form-group">
            <select class="form-select" id="jabatan" name="jabatan" required>
                <option value="" disabled selected>Pilih Jabatan</option>
                <option value="Ketua">Ketua</option>
                <option value="Wakil Ketua">Wakil Ketua</option>
                <option value="Sekretaris">Sekretaris</option>
                <option value="Bendahara">Bendahara</option>
                <option value="Divisi Humas">Divisi Humas</option>
                <option value="Divisi Manajer Proyek">Divisi Manajer Proyek</option>
                <option value="Divisi PDD">Divisi PDD</option>
                <option value="Divisi Perkab">Divisi Perkab</option>
            </select>
        </fieldset>
        @error('jabatan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                   value="{{ old('alamat', $anggota->alamat ?? '') }}" placeholder="Masukkan alamat lengkap anggota">
            @error('alamat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="alamat">Foto</label>
            <input type="file" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                   value="{{ old('alamat', $anggota->alamat ?? '') }}" placeholder="Tambahkan foto anggota">
            @error('alamat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    
</div>