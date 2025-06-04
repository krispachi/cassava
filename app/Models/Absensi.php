<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'kegiatan_id',
        'mahasiswa_id',
        'waktu_absen',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($absensi) {
            // Update TAK points when attendance status changes
            TAK::updateUserTAKPoints($absensi->mahasiswa_id);
        });

        static::deleted(function ($absensi) {
            // Update TAK points when attendance record is deleted
            TAK::updateUserTAKPoints($absensi->mahasiswa_id);
        });
    }

    /**
     * Relasi ke Kegiatan
     */
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
