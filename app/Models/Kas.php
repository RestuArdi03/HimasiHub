<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    protected $table = 'kas';

    protected $fillable = [
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
