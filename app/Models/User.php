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
        'name',
        'email',
        'foto',
        'password',
        'role_id',
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

    // RELASI DENGAN TABEL ANGGOTA
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    // KEPANITIAAN
    public function kepanitiaan()
    {
        // User memiliki banyak Kegiatan melalui tabel kepanitiaan
        return $this->belongsToMany(Kegiatan::class, 'kepanitiaan', 'users_id', 'kegiatan_id')
                    ->withPivot('jabatan') // Menambahkan kolom 'jabatan' ke hasil query
                    ->withTimestamps();
    }
}
