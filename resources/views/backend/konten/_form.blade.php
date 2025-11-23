@csrf
<div class="row">
    <div class="col-md-12">
        {{-- Judul --}}
        <div class="form-group">
            <label for="judul">Judul Publikasi</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                value="{{ old('judul', $konten->judul ?? '') }}" required autocomplete="off">
            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="form-group">
            <label for="gambar">Gambar Sampul</label>
            <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" {{ isset($konten) ? '' : 'required' }}>
            @if(isset($konten))
                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
            @endif
            @error('gambar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            @if (isset($konten) && $konten->gambar)
                <div class="mt-2">
                    <img src="{{ Str::startsWith($konten->gambar, 'http') ? $konten->gambar : Storage::url($konten->gambar) }}" alt="Gambar saat ini" class="img-thumbnail"
                        width="200">
                </div>
            @endif
        </div>

        {{-- Pilihan Input Konten --}}
        <div class="form-group">
            <label>Sumber Konten</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="content_source" id="source_editor" value="editor" checked>
                <label class="form-check-label" for="source_editor">
                    Tulis manual menggunakan editor
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="content_source" id="source_file" value="file">
                <label class="form-check-label" for="source_file">
                    Unggah dari file (.docx)
                </label>
            </div>
        </div>

        {{-- Deskripsi (Rich Text Editor) --}}
        <div class="form-group">
            <label for="deskripsi">Isi Konten</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                rows="10">{{ old('deskripsi', $konten->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">
                    {{ $message }} 
                </div>
            @enderror
        </div>

        {{-- Unggah File DOCX --}}
        <div class="form-group" id="file-upload-container" style="display: none;">
            <label for="file_konten">Unggah File Konten (.docx)</label>
            <input class="form-control @error('file_konten') is-invalid @enderror" type="file" id="file_konten" name="file_konten" accept=".docx">
            @error('file_konten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>