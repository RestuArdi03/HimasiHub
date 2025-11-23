<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;
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
