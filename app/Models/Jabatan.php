<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
