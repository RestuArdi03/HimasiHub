<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // RELASI DENGAN TABEL SALDO
    public function saldo(): BelongsTo
    {
        return $this->belongsTo(Saldo::class);
    }
}
