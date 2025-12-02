<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Anggota;

class Notulen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'notulen';

    protected $fillable = [
        'judul_rapat',
        'catatan_tambahan',
        'tanggal_rapat',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'tipe_rapat',
        'pimpinan_rapat_nama',
        'pimpinan_rapat_id',
        'notulis_nama',
        'notulis_id',
    ];

    // RELASI DENGAN TABEL KEGIATAN
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI DENGAN TABEL ANGGOTA (Pimpinan Rapat)
    public function pimpinan()
    {
        return $this->belongsTo(Anggota::class, 'pimpinan_rapat_id');
    }

    // RELASI DENGAN TABEL ANGGOTA (Notulis)
    public function notulis()
    {
        return $this->belongsTo(Anggota::class, 'notulis_id');
    }

    // RELASI DENGAN TABEL AGENDA
    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }

    // RELASI DENGAN TABEL DOKUMENTASI
    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class);
    }
}
