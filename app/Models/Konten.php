<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;
    protected $table = 'konten';

    protected $fillable = [
        'judul',
        'gambar',
        'deskripsi',
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
