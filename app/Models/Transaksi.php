<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'debit',
        'kredit',
        'saldo',
        'keterangan',
        'gambar',
        'users_id',
    ];

    // RELASI DENGAN TABEL USER
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
