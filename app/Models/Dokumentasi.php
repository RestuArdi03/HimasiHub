<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;
    protected $table = 'dokumentasi';

    protected $fillable = [
        'tipe',
        'path',
        'notulen_id',
    ];

    // RELASI DENGAN TABEL NOTULEN
    public function notulen()
    {
        return $this->belongsTo(Notulen::class);
    }
}
