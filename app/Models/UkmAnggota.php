<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UkmAnggota extends Model
{
    protected $table = 'ukm_anggota';

    protected $fillable = [
        'ukm_id',
        'mahasiswa_id',
        'jabatan',
        'is_active',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke UKM
     */
    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Relasi ke Pembina yang menyetujui
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Pembina::class, 'approved_by');
    }

    /**
     * Scope untuk anggota yang pending approval
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk anggota yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk anggota yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
