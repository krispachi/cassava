<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Services\MahasiswaService;
use Illuminate\Console\Command;

class SyncUserMahasiswa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-user-mahasiswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data antara tabel User dan Mahasiswa';



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi User dan Mahasiswa...');

        // Ambil semua user dengan peran Mahasiswa
        $users = User::where('peran', 'Mahasiswa')->get();

        $this->info("Ditemukan {$users->count()} user dengan peran Mahasiswa");
        $created = 0;
        $updated = 0;

        foreach ($users as $user) {
            // Cek apakah sudah ada data mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            // Menggunakan service untuk sinkronisasi data
            MahasiswaService::syncUserWithMahasiswa($user);

            if (!$mahasiswa) {
                $created++;
            } else {
                $updated++;
            }
        }

        // Sinkronkan juga data total_tak dari mahasiswa ke user
        $this->info("Memperbarui poin TAK dari Mahasiswa ke User...");
        $mahasiswas = Mahasiswa::with('user')->get();
        $takUpdated = 0;

        foreach ($mahasiswas as $mahasiswa) {
            if ($mahasiswa->user) {
                $user = $mahasiswa->user;

                // Hitung ulang TAK berdasarkan record TAK dan Absensi
                $this->calculateAndUpdateTAK($mahasiswa);
                $takUpdated++;
            }
        }

        $this->info("Sinkronisasi selesai:");
        $this->info("- {$created} data Mahasiswa baru dibuat");
        $this->info("- {$updated} data Mahasiswa diupdate");
        $this->info("- {$takUpdated} data poin TAK diupdate");

        return Command::SUCCESS;
    }

    /**
     * Hitung dan perbarui poin TAK untuk mahasiswa
     */
    private function calculateAndUpdateTAK(Mahasiswa $mahasiswa)
    {
        // Menggunakan metode yang ada di model TAK
        \App\Models\TAK::updateUserTAKPoints($mahasiswa->id);
    }
}
