<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agenda';

    protected $fillable = [
        'topik',
        'hasil_pembahasan',
        'status',
        'notulen_id',
    ];

    // RELASI DENGAN TABEL NOTULEN
    public function notulen()
    {
        return $this->belongsTo(Notulen::class);
    }
}
