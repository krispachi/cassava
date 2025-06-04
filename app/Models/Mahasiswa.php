<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'fakultas',
        'angkatan',
        'total_tak',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke UKM Anggota
     */
    public function ukmAnggota(): HasMany
    {
        return $this->hasMany(UkmAnggota::class);
    }

    /**
     * Relasi ke Absensi
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Get UKM yang diikuti
     */
    public function ukm()
    {
        return $this->belongsToMany(Ukm::class, 'ukm_anggota', 'mahasiswa_id', 'ukm_id');
    }
}
