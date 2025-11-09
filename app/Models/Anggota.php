<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'nim',
        'kelas',
        'jurusan',
        'no_hp',
        'jabatan',
        'alamat',
        'foto',
        'users_id',
        'role_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI DENGAN TABEL ROLE
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
