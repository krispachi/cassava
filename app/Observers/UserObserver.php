<?php

namespace App\Observers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Services\MahasiswaService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Jika user baru adalah Mahasiswa, buat record di tabel mahasiswa
        if ($user->peran === 'Mahasiswa') {
            MahasiswaService::syncUserWithMahasiswa($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Jika user diupdate dan perannya berubah menjadi Mahasiswa
        if ($user->peran === 'Mahasiswa') {
            MahasiswaService::syncUserWithMahasiswa($user);
        }
    }
}
