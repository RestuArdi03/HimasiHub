<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';

    protected $fillable = [
        'nama',
        'tipe',
        'waktu_mulai',
        'tempat',
        'waktu_selesai',
        'pimpinan_kegiatan_id',
    ];

    // RELASI DENGAN TABEL PIMPINAN KEGIATAN
    public function pimpinan_kegiatan()
    {
        return $this->belongsTo(PimpinanKegiatan::class);
    }

    // KEPANITIAAN
    public function kepanitiaan()
    {
        return $this->belongsToMany(User::class, 'kepanitiaan', 'kegiatan_id', 'users_id')
                    ->withPivot('jabatan') // Menambahkan kolom 'jabatan' ke hasil query
                    ->withTimestamps();
    }
}
