<?php

namespace App\Models;

// Tambahkan tiga baris ini:
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function borrowings()
    {
        return $this->hasMany(\App\Models\Borrowing::class);
    }

    public function isLibrarian(): bool
    {
        return $this->role === 'librarian';
    }
}
