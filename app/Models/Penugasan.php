<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;
    protected $table = 'penugasan';

    protected $fillable = [
        'tugas',
        'kepanitiaan_id',
        'users_id',
        'tindak_lanjut',
        'deadline',
        'status',
        'keterangan',
    ];

    // RELASI DENGAN TABEL KEPANITIAAN
    public function kepanitiaan()
    {
        return $this->belongsTo(Kepanitiaan::class);
    }

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
