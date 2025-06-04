<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\TAK;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateTAKPointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all mahasiswa
        $allMahasiswa = Mahasiswa::all();

        $this->command->info('Updating TAK points for ' . $allMahasiswa->count() . ' students...');

        $updated = 0;

        foreach ($allMahasiswa as $mahasiswa) {
            // Use the TAK model's method to update points
            TAK::updateUserTAKPoints($mahasiswa->id);
            $updated++;

            if ($updated % 10 === 0) {
                $this->command->info("Updated $updated students so far...");
            }
        }

        $this->command->info('TAK points update completed. Updated ' . $updated . ' students.');
    }
}
