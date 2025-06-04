<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'ukm_id',
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'poin_tak',
        'status',
        'qr_code',
    ];

    /**
     * Relasi ke UKM
     */
    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }

    /**
     * Relasi ke Absensi
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Check if user has attended this kegiatan
     */
    public function isAttendedBy($mahasiswaId): bool
    {
        return $this->absensi()->where('mahasiswa_id', $mahasiswaId)
                              ->where('status', 'hadir')
                              ->exists();
    }
}
