<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\TAK;
use App\Services\MahasiswaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SyncController extends Controller
{


    /**
     * Menjalankan sinkronisasi User dan Mahasiswa
     */
    public function syncUserMahasiswa()
    {
        // Ambil semua user dengan peran Mahasiswa
        $users = User::where('peran', 'Mahasiswa')->get();

        $created = 0;
        $updated = 0;

        foreach ($users as $user) {
            // Cek apakah sudah ada data mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            // Sinkronisasi data user ke mahasiswa menggunakan service
            MahasiswaService::syncUserWithMahasiswa($user);

            if (!$mahasiswa) {
                $created++;
            } else {
                $updated++;
            }
        }

        // Update data TAK mahasiswa
        $mahasiswas = Mahasiswa::all();
        foreach ($mahasiswas as $mahasiswa) {
            TAK::updateUserTAKPoints($mahasiswa->id);
        }

        return redirect()->back()->with('success', "Sinkronisasi berhasil: $created data baru, $updated data diupdate.");
    }

    /**
     * Menjalankan update poin TAK untuk semua mahasiswa
     */
    public function updateAllTAKPoints()
    {
        $mahasiswas = Mahasiswa::all();
        $updated = 0;

        foreach ($mahasiswas as $mahasiswa) {
            TAK::updateUserTAKPoints($mahasiswa->id);
            $updated++;
        }

        return redirect()->back()->with('success', "Berhasil update poin TAK untuk $updated mahasiswa.");
    }
}
