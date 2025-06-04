<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nomor_telepon',
        'nim',
        'peran',
        'poin_tak',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * Relasi ke Pembina
     */
    public function pembina()
    {
        return $this->hasOne(Pembina::class);
    }

    /**
     * Check if user is a mahasiswa
     */
    public function isMahasiswa()
    {
        return $this->peran === 'Mahasiswa';
    }

    /**
     * Check if user is a pembina
     */
    public function isPembina()
    {
        return $this->peran === 'UKM';
    }

    /**
     * Get the user's role (alias for peran)
     */
    public function getRoleAttribute()
    {
        return $this->peran;
    }
}
