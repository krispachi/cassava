<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameter (angkatan)
        $selectedAngkatan = $request->input('angkatan');

        // Get all available angkatan for filter dropdown (sorted)
        $angkatanList = Mahasiswa::distinct('angkatan')
            ->whereNotNull('angkatan')
            ->pluck('angkatan')
            ->toArray();
        sort($angkatanList);        // Base query for leaderboard - get top mahasiswa with highest TAK points
        $leaderboardQuery = Mahasiswa::select(
            'mahasiswa.id',
            'users.name',
            'mahasiswa.nim',
            'mahasiswa.angkatan',
            'mahasiswa.prodi',
            'mahasiswa.total_tak'
        )
        ->join('users', 'mahasiswa.user_id', '=', 'users.id')
        ->where('users.peran', 'Mahasiswa')
        ->whereNotNull('mahasiswa.total_tak')
        ->where('mahasiswa.total_tak', '>', 0);

        // Apply angkatan filter if selected
        if ($selectedAngkatan) {
            $leaderboardQuery->where('mahasiswa.angkatan', $selectedAngkatan);
        }

        // Get top 10 for homepage display
        $leaderboard = $leaderboardQuery
            ->orderBy('mahasiswa.total_tak', 'desc')
            ->orderBy('users.name', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($item, $index) {
                $item->rank = $index + 1;
                return $item;
            });

        // Get top 3 for podium display
        $topThree = $leaderboard->take(3);

        // Get remaining for table (rank 4-10)
        $remainingRanks = $leaderboard->skip(3);

        return view('index', compact(
            'leaderboard',
            'topThree',
            'remainingRanks',
            'angkatanList',
            'selectedAngkatan'
        ));
    }
}
