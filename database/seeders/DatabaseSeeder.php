<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\TAKSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id'                => 2,
                'name'              => 'Krisna',
                'email'             => 'krisnaari8805@gmail.com',
                'email_verified_at' => null,
                'password'          => Hash::make(strtolower('Krisna')),
                'nomor_telepon'     => '081',
                'nim'               => '2404',
                'peran'             => 'Mahasiswa',
                'poin_tak'          => 0,
                'remember_token'    => null,
                'created_at'        => Carbon::parse('2025-05-26 07:18:41'),
                'updated_at'        => Carbon::parse('2025-05-26 07:18:41'),
            ],
            [
                'id'                => 3,
                'name'              => 'Angga',
                'email'             => 'angga@example.com',
                'email_verified_at' => null,
                'password'          => Hash::make(strtolower('Angga')),
                'nomor_telepon'     => '082',
                'nim'               => '2403',
                'peran'             => 'Mahasiswa',
                'poin_tak'          => 0,
                'remember_token'    => null,
                'created_at'        => Carbon::parse('2025-05-26 07:22:42'),
                'updated_at'        => Carbon::parse('2025-05-26 07:22:42'),
            ],
            [
                'id'                => 4,
                'name'              => 'Tude',
                'email'             => 'Tude@example.com',
                'email_verified_at' => null,
                'password'          => Hash::make(strtolower('Tude')),
                'nomor_telepon'     => '083',
                'nim'               => '2405',
                'peran'             => 'Mahasiswa',
                'poin_tak'          => 0,
                'remember_token'    => null,
                'created_at'        => Carbon::parse('2025-05-26 07:24:33'),
                'updated_at'        => Carbon::parse('2025-05-26 07:24:33'),
            ],
            [
                'id'                => 5,
                'name'              => 'Vika',
                'email'             => 'Vika@example.com',
                'email_verified_at' => null,
                'password'          => Hash::make(strtolower('Vika')),
                'nomor_telepon'     => '084',
                'nim'               => '2406',
                'peran'             => 'UKM',
                'poin_tak'          => 0,
                'remember_token'    => null,
                'created_at'        => Carbon::parse('2025-05-26 07:24:33'),
                'updated_at'        => Carbon::parse('2025-05-26 07:24:33'),
            ],
        ]);

        DB::table('ukm')->insert([
            [
                'nama_ukm'   => 'Primakara Developers',
                'deskripsi'  => 'Komunitas Developer Bali',
                'logo'       => '<>',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_ukm'   => 'English Club',
                'deskripsi'  => 'Perkumpulan belajar bahasa Inggris',
                'logo'       => 'EC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('mahasiswa')->insert([
            [
                'user_id'    => 2,
                'nim'        => '1000',
                'prodi'      => 'Informatika',
                'fakultas'   => 'FTID',
                'angkatan'   => '24',
                'total_tak'  => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id'    => 3,
                'nim'        => '1001',
                'prodi'      => 'Informatika',
                'fakultas'   => 'FTID',
                'angkatan'   => '24',
                'total_tak'  => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id'    => 4,
                'nim'        => '1002',
                'prodi'      => 'Informatika',
                'fakultas'   => 'FTID',
                'angkatan'   => '24',
                'total_tak'  => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('ukm_anggota')->insert([
            [
                'ukm_id'      => 1,
                'mahasiswa_id'=> 1,
                'jabatan'     => 'fasilitator',
                'is_active'   => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'ukm_id'      => 1,
                'mahasiswa_id'=> 2,
                'jabatan'     => 'anggota',
                'is_active'   => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'ukm_id'      => 1,
                'mahasiswa_id'=> 3,
                'jabatan'     => 'anggota',
                'is_active'   => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);

        DB::table('pembina')->insert([
            [
                'user_id'         => 5,
                'nip'             => '2001',
                'bidang_keahlian' => 'Pemrograman',
                'ukm_id'          => 1,
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ]
        ]);
    }
}
