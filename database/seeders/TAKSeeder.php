<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Kegiatan;
use App\Models\TAK;
use Carbon\Carbon;

class TAKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing mahasiswa and kegiatan data
        $mahasiswas = Mahasiswa::all();
        $kegiatans = Kegiatan::all();

        if ($mahasiswas->isEmpty() || $kegiatans->isEmpty()) {
            $this->command->info('No mahasiswa or kegiatan data found. Please seed those tables first.');
            return;
        }

        // Generate random TAK data
        $takData = [];
        $statuses = ['diterima', 'menunggu', 'ditolak'];

        foreach ($mahasiswas as $mahasiswa) {
            // Reset total TAK for mahasiswa
            $totalTAK = 0;

            // Assign 1-5 random kegiatan to each mahasiswa
            $randomKegiatanCount = rand(1, min(5, $kegiatans->count()));
            $randomKegiatans = $kegiatans->random($randomKegiatanCount);

            foreach ($randomKegiatans as $kegiatan) {
                $status = $statuses[rand(0, 2)]; // Random status
                $poin = $status == 'diterima' ? $kegiatan->poin_tak : 0;

                // Add to total TAK if status is 'diterima'
                if ($status == 'diterima') {
                    $totalTAK += $poin;
                }

                // Create TAK record
                TAK::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'kegiatan_id' => $kegiatan->id,
                    'poin' => $kegiatan->poin_tak,
                    'keterangan' => 'Partisipasi dalam kegiatan ' . $kegiatan->nama_kegiatan,
                    'status' => $status,
                    'created_at' => Carbon::now()->subDays(rand(1, 60)), // Random date within the last 60 days
                    'updated_at' => Carbon::now(),
                ]);
            }

            // Update mahasiswa total TAK
            $mahasiswa->total_tak = $totalTAK;
            $mahasiswa->save();
        }

        $this->command->info('TAK data seeded successfully!');
    }
}
