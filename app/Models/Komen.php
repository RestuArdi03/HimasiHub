<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    use HasFactory;
    protected $table = 'komen';

    protected $fillable = [
        'isi',
        'konten_id',
        'users_id',
    ];

    // RELASI DENGAN TABEL KONTEN
    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
