<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembina extends Model
{
    protected $table = 'pembina';

    protected $fillable = [
        'user_id',
        'nip',
        'bidang_keahlian',
        'ukm_id',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke UKM
     */
    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }
}
