@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="users_id">Pilih User (Berdasarkan Email)</label>
            <select class="form-select @error('users_id') is-invalid @enderror" id="users_id" name="users_id" required>
                <option value="" disabled selected>-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" data-nama="{{ $user->nama }}" {{ old('users_id', $anggota->users_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->email }} - ({{ $user->nama }})</option>
                @endforeach
            </select>
            @error('users_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama Anggota</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $anggota->users->nama ?? '') }}" required>
            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Nama akan terisi otomatis saat memilih user, namun dapat diubah jika perlu.</small>
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $anggota->nim ?? '') }}" required>
            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $anggota->kelas ?? '') }}" required placeholder="Contoh: 19.1A.09">
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required>
                <option value="" disabled {{ old('jurusan', $anggota->jurusan ?? '') == '' ? 'selected' : '' }}>-- Pilih Jurusan --</option>
                <option value="Sistem Informasi" {{ old('jurusan', $anggota->jurusan ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            </select>
            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="jabatan_id">Jabatan</label>
            <select class="form-select @error('jabatan_id') is-invalid @enderror" id="jabatan_id" name="jabatan_id" required>
                <option value="" disabled selected>-- Pilih Jabatan --</option>
                @foreach ($jabatan as $j)
                    <option value="{{ $j->id }}" {{ old('jabatan_id', $anggota->jabatan_id ?? '') == $j->id ? 'selected' : '' }}>{{ $j->nama_jabatan }} (Role: {{ $j->role->nama_role }})</option>
                @endforeach
            </select>
            @error('jabatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no_hp">No. HP</label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $anggota->no_hp ?? '') }}">
            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="moto_hidup">Moto Hidup</label>
            <input type="text" class="form-control @error('moto_hidup') is-invalid @enderror" id="moto_hidup" name="moto_hidup" value="{{ old('moto_hidup', $anggota->moto_hidup ?? '') }}">
            @error('moto_hidup')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="instagram">Instagram (URL)</label>
            <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram', $anggota->instagram ?? '') }}" placeholder="https://instagram.com/username">
            @error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="tiktok">TikTok (URL)</label>
            <input type="url" class="form-control @error('tiktok') is-invalid @enderror" id="tiktok" name="tiktok" value="{{ old('tiktok', $anggota->tiktok ?? '') }}" placeholder="https://tiktok.com/@username">
            @error('tiktok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="foto">Foto (Rasio 1:1)</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg">
            @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('users_id');
        const namaInput = document.getElementById('nama');

        // Fungsi untuk mengisi nama berdasarkan user yang dipilih
        const updateNamaField = () => {
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            namaInput.value = selectedOption ? selectedOption.getAttribute('data-nama') || '' : '';
        };

        userSelect.addEventListener('change', updateNamaField);

        // --- LOGIKA UNTUK INPUT ANGKA (NIM & NO HP) ---
        const nimInput = document.getElementById('nim');
        const noHpInput = document.getElementById('no_hp');

        const restrictToNumbers = (event) => {
            // Ganti semua karakter non-digit menjadi string kosong
            event.target.value = event.target.value.replace(/\D/g, '');
        };

        nimInput.addEventListener('input', restrictToNumbers);
        noHpInput.addEventListener('input', restrictToNumbers);

        // Panggil fungsi saat halaman dimuat untuk menangani nilai dari old()
        updateNamaField();

        // --- LOGIKA UNTUK SUBMIT FORM UTAMA ---
        const mainForm = userSelect.closest('form');
        if (mainForm) {
            mainForm.addEventListener('submit', function() {
                mainForm.classList.add('was-validated');
            });
        }
    });
</script>
@endpush