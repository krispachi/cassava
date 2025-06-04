<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\TAK;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTAKDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update mahasiswa TAK data
        $angga = Mahasiswa::where('nim', '1001')->first();
        if ($angga) {
            $angga->total_tak = 1000000;
            $angga->save();

            // Update user poin_tak juga
            $user = User::find($angga->user_id);
            if ($user) {
                $user->poin_tak = 1000000;
                $user->save();
            }
        }

        $krisna = Mahasiswa::where('nim', '1000')->first();
        if ($krisna) {
            $krisna->total_tak = 0;
            $krisna->save();

            $user = User::find($krisna->user_id);
            if ($user) {
                $user->poin_tak = 0;
                $user->save();
            }
        }

        $tude = Mahasiswa::where('nim', '1002')->first();
        if ($tude) {
            $tude->total_tak = 0;
            $tude->save();

            $user = User::find($tude->user_id);
            if ($user) {
                $user->poin_tak = 0;
                $user->save();
            }
        }

        // Hapus data TAK yang ada sebelum menambahkan yang baru
        DB::table('tak')->truncate();

        // Buat kegiatan jika belum ada
        $turuKegiatan = Kegiatan::firstOrCreate(
            ['nama_kegiatan' => 'turu'],
            [
                'ukm_id' => 1,
                'deskripsi' => 'Kegiatan turu - Primakara Developers',
                'tanggal_mulai' => Carbon::parse('2025-07-18'),
                'tanggal_selesai' => Carbon::parse('2025-07-18'),
                'lokasi' => 'Kampus',
                'poin_tak' => 1000000,
                'status' => 'selesai',
                'qr_code' => 'turu-'.time(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $mengcookKegiatan = Kegiatan::firstOrCreate(
            ['nama_kegiatan' => 'MENGCOOK'],
            [
                'ukm_id' => 1,
                'deskripsi' => 'Kegiatan MENGCOOK - Primakara Developers',
                'tanggal_mulai' => Carbon::parse('2025-06-04'),
                'tanggal_selesai' => Carbon::parse('2025-06-04'),
                'lokasi' => 'Kampus',
                'poin_tak' => 14,
                'status' => 'selesai',
                'qr_code' => 'mengcook-'.time(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // Buat riwayat TAK untuk Krisna
        if ($krisna) {
            // TAK turu (ditolak)
            TAK::create([
                'mahasiswa_id' => $krisna->id,
                'kegiatan_id' => $turuKegiatan->id,
                'poin' => 1000000,
                'keterangan' => 'Partisipasi dalam kegiatan turu',
                'status' => 'ditolak',
                'created_at' => Carbon::parse('2025-07-18'),
                'updated_at' => Carbon::parse('2025-07-18'),
            ]);

            // TAK MENGCOOK (menunggu)
            TAK::create([
                'mahasiswa_id' => $krisna->id,
                'kegiatan_id' => $mengcookKegiatan->id,
                'poin' => 14,
                'keterangan' => 'Partisipasi dalam kegiatan MENGCOOK',
                'status' => 'menunggu',
                'created_at' => Carbon::parse('2025-06-04'),
                'updated_at' => Carbon::parse('2025-06-04'),
            ]);
        }

        // Memberikan TAK diterima untuk Angga agar total sesuai dengan nilai 1000000
        if ($angga && $turuKegiatan) {
            TAK::create([
                'mahasiswa_id' => $angga->id,
                'kegiatan_id' => $turuKegiatan->id,
                'poin' => 1000000,
                'keterangan' => 'Partisipasi dalam kegiatan turu',
                'status' => 'diterima',
                'created_at' => Carbon::parse('2025-06-03'),
                'updated_at' => Carbon::parse('2025-06-03'),
            ]);
        }

        $this->command->info('Data TAK berhasil diperbarui sesuai screenshot.');
    }
}
