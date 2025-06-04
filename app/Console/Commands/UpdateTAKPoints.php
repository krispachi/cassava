<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\TAK;
use Illuminate\Console\Command;

class UpdateTAKPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-tak-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update poin TAK untuk semua mahasiswa berdasarkan riwayat kegiatan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update poin TAK untuk semua mahasiswa...');

        // Ambil semua mahasiswa
        $mahasiswas = Mahasiswa::all();
        $total = $mahasiswas->count();
        $updated = 0;

        $this->output->progressStart($total);

        foreach ($mahasiswas as $mahasiswa) {
            TAK::updateUserTAKPoints($mahasiswa->id);
            $updated++;
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info("Update poin TAK selesai: {$updated} dari {$total} mahasiswa diupdate.");

        return Command::SUCCESS;
    }
}
