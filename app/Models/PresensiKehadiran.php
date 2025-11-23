<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiKehadiran extends Model
{
    use HasFactory;
    protected $table = 'presensi_kehadiran';

    protected $fillable = [
        'peserta_nama',
        'user_id',
        'presensiable_id',
        'presensiable_type',
        'keterangan_kehadiran',
    ];

    // RELASI DENGAN TABEL ANGGOTA
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // RELASI DENGAN TABEL KEGIATAN
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function presensiable()
    {
        return $this->morphTo();
    }
}
