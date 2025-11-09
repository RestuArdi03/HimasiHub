<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    use HasFactory;
    protected $table = 'usulan';

    protected $fillable = [
        'isi',
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
