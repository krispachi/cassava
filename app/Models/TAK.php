<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TAK extends Model
{
    protected $table = 'tak';

    protected $fillable = [
        'mahasiswa_id',
        'kegiatan_id',
        'poin',
        'keterangan',
        'status'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($tak) {
            static::updateUserTAKPoints($tak->mahasiswa_id);
        });

        static::deleted(function ($tak) {
            static::updateUserTAKPoints($tak->mahasiswa_id);
        });
    }

    /**
     * Update the user's TAK points based on all approved TAK records and attendance
     */
    public static function updateUserTAKPoints($mahasiswaId)
    {
        $mahasiswa = Mahasiswa::find($mahasiswaId);
        if (!$mahasiswa || !$mahasiswa->user) {
            return;
        }

        // Auto-approve all TAK records from UKM kegiatan
        $pendingTakRecords = TAK::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'menunggu')
            ->with('kegiatan.ukm')
            ->get();

        foreach ($pendingTakRecords as $takRecord) {
            if ($takRecord->kegiatan && $takRecord->kegiatan->ukm) {
                // Automatically approve TAK records from UKM activities
                $takRecord->status = 'diterima';
                $takRecord->save();
            }
        }

        // Calculate points from TAK records with status 'diterima'
        $takPoints = TAK::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'diterima')
            ->sum('poin');

        // Calculate points from Absensi records with status 'hadir'
        $absensiPoints = 0;
        $absensiRecords = Absensi::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'hadir')
            ->with('kegiatan')
            ->get();

        foreach ($absensiRecords as $absensi) {
            if ($absensi->kegiatan) {
                $absensiPoints += $absensi->kegiatan->poin_tak;
            }
        }

        // Update both mahasiswa and user records
        $totalPoints = $takPoints + $absensiPoints;

        $mahasiswa->total_tak = $totalPoints;
        $mahasiswa->save();

        $mahasiswa->user->poin_tak = $totalPoints;
        $mahasiswa->user->save();

        return $totalPoints;
    }

    /**
     * Get the mahasiswa that owns the TAK record
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the kegiatan that the TAK is associated with
     */
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
