<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama_role',
    ];

    /**
     * Users that belong to this role (one-to-many).
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
