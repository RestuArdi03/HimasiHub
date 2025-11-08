<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'saldo_id',
        'type',
        'amount',
        'keterangan',
        'bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function saldo()
    {
        return $this->belongsTo(Saldo::class);
    }
}
