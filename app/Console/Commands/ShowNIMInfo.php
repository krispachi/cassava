<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Services\MahasiswaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShowNIMInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-nim-info {nim? : Specific NIM to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menampilkan informasi yang diekstraksi dari NIM mahasiswa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nim = $this->argument('nim');

        if ($nim) {
            // Show info for specific NIM
            $this->showInfoForNIM($nim);
        } else {
            // Show all NIMs in database
            $this->showAllNIMs();
        }

        return Command::SUCCESS;
    }

    /**
     * Show info for a specific NIM
     */
    private function showInfoForNIM($nim)
    {
        $this->info("Informasi untuk NIM: $nim");
        $this->newLine();

        $nimInfo = MahasiswaService::extractInfoFromNim($nim);

        $this->table(
            ['NIM', 'Angkatan', 'Program Studi', 'Fakultas'],
            [[$nim, $nimInfo['angkatan'], $nimInfo['prodi'], $nimInfo['fakultas']]]
        );

        // Check if NIM exists in database
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        if ($mahasiswa) {
            $this->info("NIM ini terdaftar untuk mahasiswa dengan ID: {$mahasiswa->id} (User ID: {$mahasiswa->user_id})");
            $this->info("Data di database: Angkatan {$mahasiswa->angkatan}, Prodi {$mahasiswa->prodi}, Fakultas {$mahasiswa->fakultas}");
        } else {
            $this->warn("NIM ini belum terdaftar di database.");
        }
    }

    /**
     * Show all NIMs and interpretations
     */
    private function showAllNIMs()
    {
        $users = DB::table('users')
            ->select('users.nim', 'users.name')
            ->whereNotNull('nim')
            ->where('nim', '!=', '')
            ->get();

        if ($users->isEmpty()) {
            $this->warn("Tidak ada NIM terdaftar di database.");
            return;
        }

        $this->info("Daftar NIM dan interpretasinya:");
        $this->newLine();

        $rows = [];
        foreach ($users as $user) {
            $nimInfo = MahasiswaService::extractInfoFromNim($user->nim);
            $rows[] = [
                $user->nim,
                $user->name,
                $nimInfo['angkatan'],
                $nimInfo['prodi'],
                $nimInfo['fakultas']
            ];
        }

        $this->table(
            ['NIM', 'Nama', 'Angkatan', 'Program Studi', 'Fakultas'],
            $rows
        );

        $this->info("Total: " . count($rows) . " NIM");
        $this->info("Untuk melihat informasi spesifik, gunakan: php artisan app:show-nim-info [nim]");
    }
}
