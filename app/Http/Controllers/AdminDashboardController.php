<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pembina;
use App\Models\UkmAnggota;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        // Simple role check without middleware - admin can access everything
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            $user = auth()->user();
            if ($user->role !== 'Admin') {
                abort(403, 'Access denied. Admin role required.');
            }

            return $next($request);
        });
    }

    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_ukm' => Ukm::count(),
            'total_mahasiswa' => Mahasiswa::count(),
            'total_pembina' => Pembina::count(),
            'total_kegiatan' => Kegiatan::count(),
            'pending_requests' => UkmAnggota::where('status', 'pending')->count(),
            'approved_requests' => UkmAnggota::where('status', 'approved')->count(),
            'rejected_requests' => UkmAnggota::where('status', 'rejected')->count(),
            'total_requests' => UkmAnggota::count(),
            'active_kegiatan' => Kegiatan::where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->count(),
            'upcoming_kegiatan' => Kegiatan::where('tanggal_mulai', '>', now())
                ->count(),
        ];

        $recent_ukms = Ukm::with(['pembina', 'pembina.user'])
            ->latest()
            ->take(5)
            ->get();

        $recent_requests = UkmAnggota::with(['mahasiswa', 'mahasiswa.user', 'ukm'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Get upcoming kegiatan
        $upcoming_kegiatan = Kegiatan::with('ukm')
            ->where('tanggal_mulai', '>', now())
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();

        // Get recent activities (latest membership changes, new UKMs, etc.)
        $recent_activities = collect();

        // Add recent membership changes
        $membership_activities = UkmAnggota::with(['mahasiswa', 'mahasiswa.user', 'ukm'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'membership_' . $item->status,
                    'data' => $item,
                    'created_at' => $item->updated_at
                ];
            });

        // Add recent UKM creations
        $ukm_activities = Ukm::latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'ukm_created',
                    'data' => $item,
                    'created_at' => $item->created_at
                ];
            });

        // Add recent kegiatan
        $kegiatan_activities = Kegiatan::with('ukm')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'kegiatan_created',
                    'data' => $item,
                    'created_at' => $item->created_at
                ];
            });

        // Merge all activities and sort by creation date
        $recent_activities = $membership_activities->concat($ukm_activities)
            ->concat($kegiatan_activities)
            ->sortByDesc('created_at')
            ->take(10);

        return view('admin.dashboard_new', compact(
            'stats',
            'recent_ukms',
            'recent_requests',
            'upcoming_kegiatan',
            'recent_activities'
        ));
    }

    /**
     * Show UKM management page
     */
    public function manageUkm()
    {
        $ukms = Ukm::with(['pembina', 'pembina.user', 'anggota' => function($query) {
            $query->where('status', 'approved');
        }])->get();

        return view('admin.ukm-management', compact('ukms'));
    }

    /**
     * Show form to create new UKM
     */
    public function createUkm()
    {
        // Get users with UKM role who don't have a UKM assigned yet
        $availablePembinas = User::where('peran', 'UKM')
            ->whereDoesntHave('pembina')
            ->get();

        return view('admin.create-ukm', compact('availablePembinas'));
    }

    /**
     * Store new UKM
     */
    public function storeUkm(Request $request)
    {
        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255|unique:ukm,nama_ukm',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pembina_user_id' => 'required|exists:users,id',
            'nip' => 'required|string|unique:pembina,nip',
            'bidang_keahlian' => 'nullable|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('ukm-logos', 'public');
            }

            // Create UKM
            $ukm = Ukm::create([
                'nama_ukm' => $validated['nama_ukm'],
                'deskripsi' => $validated['deskripsi'],
                'logo' => $logoPath,
            ]);

            // Create Pembina
            Pembina::create([
                'user_id' => $validated['pembina_user_id'],
                'nip' => $validated['nip'],
                'bidang_keahlian' => $validated['bidang_keahlian'],
                'ukm_id' => $ukm->id,
            ]);

            \DB::commit();

            return redirect()->route('admin.ukm-management')->with('success', 'UKM berhasil dibuat dengan pembina yang ditugaskan.');
        } catch (\Exception $e) {
            \DB::rollback();

            // Delete uploaded logo if exists
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat UKM: ' . $e->getMessage());
        }
    }

    /**
     * Show edit UKM form
     */
    public function editUkm(Ukm $ukm)
    {
        $availablePembinas = User::where('peran', 'UKM')
            ->where(function($query) use ($ukm) {
                $query->whereDoesntHave('pembina')
                      ->orWhereHas('pembina', function($q) use ($ukm) {
                          $q->where('ukm_id', $ukm->id);
                      });
            })
            ->get();

        return view('admin.edit-ukm', compact('ukm', 'availablePembinas'));
    }

    /**
     * Update UKM
     */
    public function updateUkm(Request $request, Ukm $ukm)
    {
        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255|unique:ukm,nama_ukm,' . $ukm->id,
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pembina_user_id' => 'required|exists:users,id',
            'nip' => 'required|string|unique:pembina,nip,' . ($ukm->pembina->id ?? 0),
            'bidang_keahlian' => 'nullable|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
                    Storage::disk('public')->delete($ukm->logo);
                }

                $logoPath = $request->file('logo')->store('ukm-logos', 'public');
                $validated['logo'] = $logoPath;
            }

            // Update UKM
            $ukm->update([
                'nama_ukm' => $validated['nama_ukm'],
                'deskripsi' => $validated['deskripsi'],
                'logo' => $validated['logo'] ?? $ukm->logo,
            ]);

            // Update or create Pembina
            if ($ukm->pembina) {
                $ukm->pembina->update([
                    'user_id' => $validated['pembina_user_id'],
                    'nip' => $validated['nip'],
                    'bidang_keahlian' => $validated['bidang_keahlian'],
                ]);
            } else {
                Pembina::create([
                    'user_id' => $validated['pembina_user_id'],
                    'nip' => $validated['nip'],
                    'bidang_keahlian' => $validated['bidang_keahlian'],
                    'ukm_id' => $ukm->id,
                ]);
            }

            \DB::commit();

            return redirect()->route('admin.ukm-management')->with('success', 'UKM berhasil diperbarui.');
        } catch (\Exception $e) {
            \DB::rollback();

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui UKM: ' . $e->getMessage());
        }
    }

    /**
     * Delete UKM
     */
    public function deleteUkm(Ukm $ukm)
    {
        try {
            \DB::beginTransaction();

            // Delete logo file
            if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
                Storage::disk('public')->delete($ukm->logo);
            }

            // Delete UKM (cascade will handle related records)
            $ukm->delete();

            \DB::commit();

            return redirect()->route('admin.ukm-management')->with('success', 'UKM berhasil dihapus.');
        } catch (\Exception $e) {
            \DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus UKM: ' . $e->getMessage());
        }
    }

    /**
     * Approve a UKM membership request
     */
    public function approveMembership(UkmAnggota $membership)
    {
        $membership->update([
            'status' => 'approved',
            'is_active' => 1,
            'approved_at' => now()
        ]);

        return redirect()->back()->with('success', 'Permintaan keanggotaan berhasil disetujui.');
    }

    /**
     * Reject a UKM membership request
     */
    public function rejectMembership(UkmAnggota $membership)
    {
        $membership->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()->back()->with('success', 'Permintaan keanggotaan berhasil ditolak.');
    }
}
