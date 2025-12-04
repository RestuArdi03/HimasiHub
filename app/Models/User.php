<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role_id',
        'anggota_id',
        'google_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The role this user belongs to.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->role->nama_role === $role;
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param array $roles
     * @return boolean
     */
    public function hasAnyRole(array $roles): bool
    {
        // Memeriksa apakah properti 'role' ada dan apakah 'nama_role' ada di dalam array $roles.
        return $this->role && in_array($this->role->nama_role, $roles);
    }

    public function komen()
    {
        return $this->hasMany(Komen::class);
    }
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'users_id'); 
    }

    public function diskusi()
    {
        return $this->hasMany(Diskusi::class);
    }
}
