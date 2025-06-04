<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MahasiswaService;
use Exception;
use Faker\Calculator\Ean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        // Allow admin to access all user management functions
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            $user = auth()->user();
            // Only admin and the user themselves can access user management
            if ($user->role !== 'Admin' && !$request->routeIs('users.profile*')) {
                abort(403, 'Access denied. Admin role required.');
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$users = User::select(["id", "name", "nim", "email", "nomor_telepon", "peran", "created_at"]);
			return DataTables::of($users)
				->addIndexColumn()
				->addColumn("aksi", function ($user) {
					return '<span style="white-space: nowrap">
                                <a href="' . route("users.profile.show", $user->id) . '" class="btn btn-info btn-sm">
                                    <i class="fa-regular fa-id-badge me-2"></i>Profil
                                </a>
                                <a href="' . route("users.edit", $user->id) . '" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>Ubah
                                </a>
								<button type="submit" class="btn btn-danger btn-sm text-light button-delete" data-id="' . $user->id . '" data-name="' . $user->name . '">
									<i class="fa-regular fa-trash-can me-2"></i>Hapus
								</button>
                            </span>';
				})
                ->addColumn("created_at", function($user) {
                    return $user->created_at->format("d F Y H:i:s");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at, '%d %M %Y %H:%i:%s') LIKE ?", ["%$keyword%"]);
                })
                ->orderColumn("created_at", function($query, $order) {
                    $query->orderBy("created_at", $order);
                })
				->rawColumns(["aksi", "created_at"])
                ->makeHidden(["id"])
				->make(true);
		}

        return view("users.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "nim" => "required|string|unique:users",
            "nomor_telepon" => "required|string",
            "peran" => "required|string|in:Admin,Mahasiswa,UKM",
            "email" => "required|email|unique:users",
            "password" => "required|string|confirmed|min:4"
        ]);
        $validatedData["created_at"] = date("Y-m-d H:i:s");
        $validatedData["updated_at"] = date("Y-m-d H:i:s");

        try {
            $user = User::create($validatedData);

            // Jika user adalah mahasiswa, sync data mahasiswa berdasarkan NIM
            // Observer User sudah akan menangani ini, tapi kita pastikan di sini juga
            if ($user->peran === 'Mahasiswa') {
                MahasiswaService::syncUserWithMahasiswa($user);
            }

            return redirect()->route("users.index")->with("success", "User " . $validatedData["name"] . " berhasil ditambah.");
        } catch (Exception $exception) {
            return redirect()->route("users.create")->withInput()->with("error", $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $userId)
    {
        try {
            $userData = User::select(["id", "name", "nim", "nomor_telepon", "peran", "email"])->where("id", $userId)->first();

            if(empty($userData)) {
                throw new Exception("User tidak ditemukan.");
            }

            return view("users.edit", [
                "user" => $userData
            ]);
        } catch (Exception $exception) {
            return redirect()->route("users.index")->with("error", $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if(empty($user)) {
            return redirect()->route("users.index")->with("error", "User tidak ditemukan.");
        }

        $validatedData = $request->validate([
            "name" => "required|string",
            "nim" => "required|string|unique:users,nim," . $user->id,
            "nomor_telepon" => "required|string",
            "peran" => "required|string|in:Admin,Mahasiswa,UKM",
            "email" => "required|email|unique:users,email," . $user->id,
            "password" => "nullable|string|confirmed|min:4"
        ]);
        $validatedData["updated_at"] = date("Y-m-d H:i:s");

        // Jika password kosong, maka hapus variabel
        if(empty($validatedData["password"])) {
            unset($validatedData["password"]);
        }

        try {
            $user->update($validatedData);

            // Jika user adalah mahasiswa, update data mahasiswa berdasarkan NIM
            if ($user->peran === 'Mahasiswa') {
                MahasiswaService::syncUserWithMahasiswa($user);
            }

            return redirect()->route("users.index")->with("success", "User " . $validatedData["name"] . " berhasil diubah.");
        } catch (Exception $exception) {
            return redirect()->route("users.edit", $user->id)->withInput()->with("error", $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        try {
            if(empty($user)) {
                throw new Exception("User tidak ditemukan.");
            }

            $userId = $user->id;
            $user->delete();

            if($userId == (auth()->user()->id ?? -1)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $request->session()->flash("success", "User berhasil dihapus.");
                return response()->json(["redirect" => route("login")]);
            }

            return response()->json(["success" => "User berhasil dihapus."]);
        } catch (Exception $exception) {
            return response()->json(["error" => $exception->getMessage()]);
        }
    }

    public function profile(int $userId = null)
    {
        try {
            if(empty($userId)) {
                $userId = auth()->user()->id ?? -1;
            }

            $userData = User::with([
                    'mahasiswa.absensi.kegiatan.ukm',
                    'pembina.ukm.kegiatan.absensi',
                    'mahasiswa.ukm'
                ])
                ->select(["id", "name", "nim", "email", "nomor_telepon", "peran", "poin_tak"])
                ->where("id", $userId)
                ->first();

            if(empty($userData)) {
                throw new Exception("User tidak ditemukan.");
            }

            // Get recent activities
            $recentActivities = [];
            $totalKegiatan = 0;
            $takSemesterIni = 0;
            $totalTak = $userData->poin_tak ?? 0;

            if ($userData->isMahasiswa() && $userData->mahasiswa) {
                // Calculate TAK for current semester (considering current date is June 2025)
                $currentYear = 2025;
                $currentMonth = 6;
                $semesterStart = ($currentMonth >= 2 && $currentMonth <= 7)
                    ? "$currentYear-01-01" // Spring semester (Jan-Jun)
                    : "$currentYear-07-01"; // Fall semester (Jul-Dec)

                // Get all kegiatan user has attended through absensi
                $absensiData = $userData->mahasiswa->absensi()
                    ->with(['kegiatan.ukm'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                if ($absensiData) {
                    // Calculate total kegiatan
                    $totalKegiatan = $absensiData->count();

                    // Get TAK for current semester
                    $takSemesterIni = $absensiData
                        ->where('created_at', '>=', $semesterStart)
                        ->sum(function ($absensi) {
                            return $absensi->kegiatan->poin_tak ?? 0;
                        });

                    // Get 3 most recent activities for the activity feed
                    $recentActivities = $absensiData->take(3);
                }
            }

            return view("users.profile", [
                "user" => $userData,
                "recentActivities" => $recentActivities,
                "totalKegiatan" => $totalKegiatan,
                "takSemesterIni" => $takSemesterIni,
                "totalTak" => $totalTak
            ]);
        } catch (Exception $exception) {
            if(auth()->user()->peran ?? -1 == "Admin") {
                return redirect()->route("users.index")->with("error", $exception->getMessage());
            } else {
                return redirect()->route("dashboard.index")->with("error", $exception->getMessage());
            }
        }
    }
}
