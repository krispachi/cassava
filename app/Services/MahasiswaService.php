<?php

namespace App\Services;

class MahasiswaService
{
    /**
     * Extract student information from NIM
     *
     * @param string|null $nim
     * @return array
     */
    public static function extractInfoFromNim($nim)
    {
        $info = [
            'angkatan' => date('Y'),
            'prodi' => 'Teknik Informatika',
            'fakultas' => 'Teknik'
        ];

        if ($nim && strlen($nim) >= 2) {
            // Extract angkatan from first 2 digits
            $twoDigits = substr($nim, 0, 2);
            if (is_numeric($twoDigits)) {
                $info['angkatan'] = '20' . $twoDigits; // Asumsi 20xx
            }

            // Extract prodi & fakultas dari digit selanjutnya jika ada
            if (strlen($nim) >= 5) {
                $prodiCode = substr($nim, 2, 3);

                // Map kode prodi ke nama prodi dan fakultas
                switch ($prodiCode) {
                    case '010':
                        $info['prodi'] = 'Teknik Informatika';
                        $info['fakultas'] = 'Teknik';
                        break;
                    case '020':
                        $info['prodi'] = 'Sistem Informasi';
                        $info['fakultas'] = 'Teknik';
                        break;
                    case '030':
                        $info['prodi'] = 'Manajemen Informatika';
                        $info['fakultas'] = 'Teknik';
                        break;
                    case '040':
                        $info['prodi'] = 'Ekonomi';
                        $info['fakultas'] = 'Ekonomi & Bisnis';
                        break;
                    case '050':
                        $info['prodi'] = 'Akuntansi';
                        $info['fakultas'] = 'Ekonomi & Bisnis';
                        break;
                    default:
                        // Default to IT if unknown
                        $info['prodi'] = 'Teknik Informatika';
                        $info['fakultas'] = 'Teknik';
                        break;
                }
            }
        }

        return $info;
    }

    /**
     * Sync mahasiswa data with user data
     *
     * @param \App\Models\User $user
     * @return \App\Models\Mahasiswa|null
     */
    public static function syncUserWithMahasiswa($user)
    {
        if (!$user || $user->peran !== 'Mahasiswa') {
            return null;
        }

        $mahasiswa = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        $nimInfo = self::extractInfoFromNim($user->nim);

        if (!$mahasiswa) {
            // Create new mahasiswa record
            $mahasiswa = \App\Models\Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $user->nim,
                'prodi' => $nimInfo['prodi'],
                'fakultas' => $nimInfo['fakultas'],
                'angkatan' => $nimInfo['angkatan'],
                'total_tak' => $user->poin_tak ?? 0,
            ]);
        } else {
            // Update existing record
            $mahasiswa->nim = $user->nim;
            $mahasiswa->prodi = $nimInfo['prodi'];
            $mahasiswa->fakultas = $nimInfo['fakultas'];
            $mahasiswa->angkatan = $nimInfo['angkatan'];
            $mahasiswa->total_tak = $user->poin_tak ?? 0;
            $mahasiswa->save();
        }

        return $mahasiswa;
    }
}
