<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\UkmAnggota;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard with relevant information based on user role
     */
    public function index()
    {
        $user = Auth::user();
        $pendingMemberships = collect();
        $activeMemberships = collect();
        $upcomingKegiatan = collect();
        $stats = [];

        // Common data - get TAK points
        $takPoints = $user->poin_tak ?? 0;

        // For Mahasiswa role, load UKM membership info
        if ($user->role === 'Mahasiswa' && $user->mahasiswa) {
            $mahasiswaId = $user->mahasiswa->id;

            // Get pending UKM membership requests
            $pendingMemberships = UkmAnggota::with('ukm')
                ->where('mahasiswa_id', $mahasiswaId)
                ->where('status', 'pending')
                ->get();

            // Get active UKM memberships
            $activeMemberships = UkmAnggota::with('ukm')
                ->where('mahasiswa_id', $mahasiswaId)
                ->where('status', 'approved')
                ->where('is_active', 1)
                ->get();

            // Get upcoming kegiatan for student's UKMs
            $ukmIds = $activeMemberships->pluck('ukm_id')->toArray();
            if (!empty($ukmIds)) {
                $upcomingKegiatan = \App\Models\Kegiatan::whereIn('ukm_id', $ukmIds)
                    ->where('tanggal_mulai', '>=', now())
                    ->orderBy('tanggal_mulai')
                    ->take(3)
                    ->get();
            }
        }
        // For UKM (Pembina) role
        elseif ($user->role === 'UKM' && $user->pembina) {
            // Get pending membership requests count
            $ukmId = $user->pembina->ukm_id ?? 0;

            if ($ukmId) {
                $pendingCount = UkmAnggota::where('ukm_id', $ukmId)
                    ->where('status', 'pending')
                    ->count();

                $stats['pendingRequests'] = $pendingCount;

                // Get upcoming kegiatan for this UKM
                $upcomingKegiatan = \App\Models\Kegiatan::where('ukm_id', $ukmId)
                    ->where('tanggal_mulai', '>=', now())
                    ->orderBy('tanggal_mulai')
                    ->take(3)
                    ->get();
            }
        }

        return view('dashboard.index', compact(
            'pendingMemberships',
            'activeMemberships',
            'upcomingKegiatan',
            'takPoints',
            'stats'
        ));
    }
}
