<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ukm extends Model
{
    protected $table = 'ukm';

    protected $fillable = [
        'nama_ukm',
        'deskripsi',
        'logo',
    ];

    /**
     * Relasi ke Kegiatan
     */
    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    /**
     * Relasi ke UKM Anggota
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(UkmAnggota::class);
    }

    /**
     * Relasi ke Pembina
     *
     * Note: This should be hasOne, not hasMany, as each UKM should have one pembina
     */
    public function pembina()
    {
        return $this->hasOne(Pembina::class);
    }
}
