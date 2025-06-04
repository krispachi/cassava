<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\KegiatanUKM;
use App\Models\Mahasiswa;
use App\Models\TAK;
use Illuminate\Http\Request;

class KegiatanUKMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatan = Kegiatan::with('ukm')->orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('kegiatan-ukm.index', compact('kegiatan'));
    }

    /**
     * Display history of kegiatan with filtering - only activities attended by current user
     */
    public function riwayat(Request $request)
    {
        // Get filter parameters
        $angkatan = $request->input('angkatan');

        // Initialize variables
        $kegiatan = collect();
        $attendedKegiatanIds = [];
        $userAttendedKegiatan = collect();

        // Only show activities if user is a mahasiswa
        if (auth()->check() && auth()->user()->peran === 'Mahasiswa' && auth()->user()->mahasiswa) {
            $mahasiswaId = auth()->user()->mahasiswa->id;

            // Get list of kegiatan they've attended
            $attendedKegiatanIds = Absensi::where('mahasiswa_id', $mahasiswaId)
                ->where('status', 'hadir')
                ->pluck('kegiatan_id')
                ->toArray();

            if (!empty($attendedKegiatanIds)) {
                // Get only the kegiatan that the user has attended
                $kegiatanQuery = Kegiatan::with(['ukm', 'absensi.mahasiswa.user'])
                    ->whereIn('id', $attendedKegiatanIds)
                    ->where('status', 'selesai')
                    ->orderBy('tanggal_selesai', 'desc');

                // Apply angkatan filter if set (filter by user's own angkatan or other students in the same activities)
                if ($angkatan) {
                    // Filter activities where there are participants from the selected angkatan
                    $filteredKegiatanIds = Absensi::whereHas('mahasiswa', function($query) use ($angkatan) {
                        $query->where('angkatan', $angkatan);
                    })->whereIn('kegiatan_id', $attendedKegiatanIds)
                      ->pluck('kegiatan_id')->unique();

                    $kegiatanQuery->whereIn('id', $filteredKegiatanIds);
                }

                // Execute the query with pagination
                $kegiatan = $kegiatanQuery->paginate(10);

                // For pagination with filter parameters
                $kegiatan->appends($request->all());

                // Set userAttendedKegiatan to the same as kegiatan since we're only showing attended activities
                $userAttendedKegiatan = $kegiatan->getCollection();
            } else {
                // If no attended activities, create empty paginated result
                $kegiatan = new \Illuminate\Pagination\LengthAwarePaginator(
                    collect(), 0, 10, 1, ['path' => request()->url()]
                );
            }
        } else {
            // If not a mahasiswa, show empty result
            $kegiatan = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(), 0, 10, 1, ['path' => request()->url()]
            );
        }

        // Get available angkatan years for the filter dropdown - only from activities the user attended
        $availableAngkatan = [];
        if (!empty($attendedKegiatanIds)) {
            $availableAngkatan = Absensi::whereIn('kegiatan_id', $attendedKegiatanIds)
                ->join('mahasiswa', 'absensi.mahasiswa_id', '=', 'mahasiswa.id')
                ->select('mahasiswa.angkatan')
                ->distinct()
                ->orderBy('mahasiswa.angkatan', 'desc')
                ->pluck('mahasiswa.angkatan')
                ->toArray();
        }

        // Get current user's TAK points if they are a student
        $userTakPoints = null;
        if (auth()->check() && auth()->user()->peran === 'Mahasiswa' && auth()->user()->mahasiswa) {
            $mahasiswaId = auth()->user()->mahasiswa->id;
            $userTakPoints = TAK::where('mahasiswa_id', $mahasiswaId)->sum('poin');
        }

        return view('kegiatan-ukm.riwayat', compact(
            'kegiatan',
            'attendedKegiatanIds',
            'userAttendedKegiatan',
            'angkatan',
            'availableAngkatan',
            'userTakPoints'
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
    public function show(KegiatanUKM $kegiatanUKM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KegiatanUKM $kegiatanUKM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KegiatanUKM $kegiatanUKM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KegiatanUKM $kegiatanUKM)
    {
        //
    }
}
