<?php

namespace App\Http\Controllers;

use App\Models\TAK;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TAKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the filter parameter (angkatan)
        $selectedAngkatan = $request->input('angkatan');

        // Get all available angkatan for filter dropdown (sorted)
        $angkatanList = Mahasiswa::distinct('angkatan')->pluck('angkatan')->toArray();
        sort($angkatanList);

        // Base query for leaderboard - get all mahasiswa
        $leaderboardQuery = Mahasiswa::select(
            'mahasiswa.id',
            'users.name',
            'mahasiswa.nim',
            'mahasiswa.angkatan',
            'users.poin_tak AS poin' // Menggunakan poin_tak dari users seperti di profil
        )
        ->join('users', 'users.id', '=', 'mahasiswa.user_id')
        ->orderByDesc('users.poin_tak'); // Order berdasarkan poin_tak user

        // Apply angkatan filter if selected
        if ($selectedAngkatan) {
            $leaderboardQuery->where('mahasiswa.angkatan', $selectedAngkatan);
        }

        // Ensure we're getting all mahasiswa (removed any hidden conditions)
        $leaderboardQuery->whereNotNull('mahasiswa.id');

        // Get the leaderboard data with pagination - show more results
        $leaderboard = $leaderboardQuery->paginate(20);

        // Find current user's rank on the leaderboard
        $userRank = null;
        $userPosition = null;
        $userTAK = null;

        if (Auth::check() && Auth::user()->isMahasiswa()) {
            // Get the current user's mahasiswa record
            $currentMahasiswa = Auth::user()->mahasiswa;

            if ($currentMahasiswa) {
                // Get the rank of the current user
                $rankQuery = DB::table('mahasiswa')
                    ->join('users', 'users.id', '=', 'mahasiswa.user_id')
                    ->select('mahasiswa.id')
                    ->orderByDesc('users.poin_tak');

                // Apply angkatan filter to rank calculation if selected
                if ($selectedAngkatan) {
                    $rankQuery->where('mahasiswa.angkatan', $selectedAngkatan);
                }

                $ranks = $rankQuery->pluck('id')->toArray();
                $userPosition = array_search($currentMahasiswa->id, $ranks);

                if ($userPosition !== false) {
                    $userRank = $userPosition + 1; // +1 because array is zero-indexed
                }

                // Get user's TAK history - similar to profile page
                $absensiData = $currentMahasiswa->absensi()
                    ->with(['kegiatan.ukm'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Transform absensi data into TAK format for display
                $userTAKCollection = collect();

                foreach ($absensiData as $absensi) {
                    if ($absensi->kegiatan) {
                        $userTAKCollection->push((object)[
                            'kegiatan' => $absensi->kegiatan,
                            'created_at' => $absensi->created_at,
                            'poin' => $absensi->kegiatan->poin_tak,
                            'status' => $absensi->status === 'hadir' ? 'diterima' : 'ditolak'
                        ]);
                    }
                }

                // Also get TAK records
                $takRecords = TAK::where('mahasiswa_id', $currentMahasiswa->id)
                    ->with('kegiatan')
                    ->orderByDesc('created_at')
                    ->get();

                foreach ($takRecords as $tak) {
                    $userTAKCollection->push($tak);
                }

                // Sort the combined collection by created_at
                $userTAKCollection = $userTAKCollection->sortByDesc('created_at');

                // Convert to paginator
                $page = request()->input('tak_page', 1);
                $perPage = 5;
                $items = $userTAKCollection->forPage($page, $perPage);
                $userTAK = new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $userTAKCollection->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
            }
        }

        return view('tak.index', compact(
            'leaderboard',
            'angkatanList',
            'selectedAngkatan',
            'userRank',
            'userTAK'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TAK $tAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TAK $tAK)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TAK $tAK)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TAK $tAK)
    {
        //
    }
}
