<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleTAKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan beberapa data kegiatan jika belum ada
        if (DB::table('kegiatan')->count() == 0) {
            DB::table('kegiatan')->insert([
                [
                    'ukm_id' => 1,
                    'nama_kegiatan' => 'Workshop Web Development',
                    'deskripsi' => 'Workshop tentang pengembangan web modern',
                    'tanggal_mulai' => Carbon::now()->subDays(30),
                    'tanggal_selesai' => Carbon::now()->subDays(29),
                    'lokasi' => 'Ruang Lab Komputer',
                    'poin_tak' => 50,
                    'status' => 'selesai',
                    'qr_code' => 'workshop-web-'.time(),
                    'created_at' => Carbon::now()->subDays(40),
                    'updated_at' => Carbon::now()->subDays(40),
                ],
                [
                    'ukm_id' => 1,
                    'nama_kegiatan' => 'Seminar UI/UX Design',
                    'deskripsi' => 'Seminar tentang prinsip dan praktik desain UI/UX',
                    'tanggal_mulai' => Carbon::now()->subDays(20),
                    'tanggal_selesai' => Carbon::now()->subDays(19),
                    'lokasi' => 'Auditorium Kampus',
                    'poin_tak' => 40,
                    'status' => 'selesai',
                    'qr_code' => 'seminar-uiux-'.time(),
                    'created_at' => Carbon::now()->subDays(30),
                    'updated_at' => Carbon::now()->subDays(30),
                ],
                [
                    'ukm_id' => 2,
                    'nama_kegiatan' => 'English Debate Competition',
                    'deskripsi' => 'Kompetisi debat bahasa Inggris tingkat fakultas',
                    'tanggal_mulai' => Carbon::now()->subDays(15),
                    'tanggal_selesai' => Carbon::now()->subDays(14),
                    'lokasi' => 'Ruang Seminar',
                    'poin_tak' => 60,
                    'status' => 'selesai',
                    'qr_code' => 'english-debate-'.time(),
                    'created_at' => Carbon::now()->subDays(20),
                    'updated_at' => Carbon::now()->subDays(20),
                ],
                [
                    'ukm_id' => 2,
                    'nama_kegiatan' => 'Public Speaking Workshop',
                    'deskripsi' => 'Workshop untuk meningkatkan kemampuan berbicara di depan umum',
                    'tanggal_mulai' => Carbon::now()->subDays(10),
                    'tanggal_selesai' => Carbon::now()->subDays(9),
                    'lokasi' => 'Ruang Serbaguna',
                    'poin_tak' => 30,
                    'status' => 'selesai',
                    'qr_code' => 'public-speaking-'.time(),
                    'created_at' => Carbon::now()->subDays(15),
                    'updated_at' => Carbon::now()->subDays(15),
                ],
                [
                    'ukm_id' => 1,
                    'nama_kegiatan' => 'Hackathon Inovasi Digital',
                    'deskripsi' => 'Kompetisi pemrograman selama 24 jam',
                    'tanggal_mulai' => Carbon::now()->subDays(5),
                    'tanggal_selesai' => Carbon::now()->subDays(4),
                    'lokasi' => 'Lab Komputer Terpadu',
                    'poin_tak' => 100,
                    'status' => 'selesai',
                    'qr_code' => 'hackathon-'.time(),
                    'created_at' => Carbon::now()->subDays(10),
                    'updated_at' => Carbon::now()->subDays(10),
                ],
            ]);
        }

        // Tambahkan data TAK untuk mahasiswa yang sudah ada
        $kegiatan = DB::table('kegiatan')->get();
        $mahasiswa = DB::table('mahasiswa')->get();

        // Daftar status untuk variasi
        $statusList = ['menunggu', 'diterima', 'ditolak'];

        // Tambahkan TAK untuk setiap mahasiswa
        foreach ($mahasiswa as $mhs) {
            $poin_tak_total = 0;

            foreach ($kegiatan as $k) {
                // Tentukan status TAK secara random
                $status = $statusList[array_rand($statusList)];

                // Hitung poin (poin hanya berlaku jika status diterima)
                $poin = $status === 'diterima' ? $k->poin_tak : 0;

                // Tambahkan ke total poin mahasiswa jika diterima
                if ($status === 'diterima') {
                    $poin_tak_total += $poin;
                }

                // Simpan data TAK
                DB::table('tak')->insert([
                    'mahasiswa_id' => $mhs->id,
                    'kegiatan_id' => $k->id,
                    'poin' => $k->poin_tak, // Simpan poin kegiatan (bukan poin yang diterima)
                    'keterangan' => 'Partisipasi dalam kegiatan ' . $k->nama_kegiatan,
                    'status' => $status,
                    'created_at' => Carbon::parse($k->tanggal_selesai)->addDays(1),
                    'updated_at' => Carbon::parse($k->tanggal_selesai)->addDays(2),
                ]);
            }

            // Update total poin TAK mahasiswa
            DB::table('mahasiswa')
                ->where('id', $mhs->id)
                ->update(['total_tak' => $poin_tak_total]);
        }
    }
}
