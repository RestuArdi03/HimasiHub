<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;
    protected $table = 'diskusi';

    protected $fillable = ['isi', 'users_id', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke pesan yang dibalas
    public function parentMessage()
    {
        return $this->belongsTo(Diskusi::class, 'parent_id');
    }

    /**
     * Check if the message has been edited.
     * A message is considered edited if updated_at is more than 10 seconds after created_at.
     * @return bool
     */
    public function isEdited(): bool
    {
        return $this->updated_at->diffInSeconds($this->created_at) > 10;
    }
}
