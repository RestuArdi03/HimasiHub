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
        'saldo_akhir',
        'keterangan',
        'gambar',
        'users_id',
        'saldo_id',
    ];

    // RELASI DENGAN TABEL USER
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // RELASI DENGAN TABEL SALDO
    public function saldo()
    {
        return $this->belongsTo(Saldo::class);
    }
}
