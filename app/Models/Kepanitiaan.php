<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepanitiaan extends Model
{
    use HasFactory;
    protected $table = 'kepanitiaan';
    
    protected $fillable = [
        'jabatan',
        'kegiatan_id',
        'users_id',
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
}
