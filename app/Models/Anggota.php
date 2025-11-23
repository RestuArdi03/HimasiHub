<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggota extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'nim',
        'kelas',
        'jurusan',
        'no_hp',
        'jabatan_id',
        'alamat',
        'foto',
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    // RELASI DENGAN TABEL JABATAN
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
