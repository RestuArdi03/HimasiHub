<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saldo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'saldo';
    protected $fillable = [
        'user_id',
        'nama',
        'balance',
        'iuran_nominal',
        'jumlah_iuran',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class);
    }
}
