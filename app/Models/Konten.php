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
        'slug',
        'gambar',
        'deskripsi',
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
