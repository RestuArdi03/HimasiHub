<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiKehadiran extends Model
{
    use HasFactory;
    protected $table = 'presensi_kehadiran';

    protected $fillable = [
        'anggota_id',
        'kegiatan_id',
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
}
