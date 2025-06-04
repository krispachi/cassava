<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\UkmAnggota;
use App\Models\Mahasiswa;
use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UkmMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display pending membership requests for pembina
     */
    public function index()
    {
        $user = Auth::user();

        // Allow both UKM and Admin roles
        if (!in_array($user->peran, ['UKM', 'Admin'])) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        if ($user->peran === 'UKM') {
            // Get pembina data for current user
            $pembina = Pembina::where('user_id', $user->id)->first();

            if (!$pembina) {
                return redirect()->back()->with('error', 'Data pembina tidak ditemukan. Pastikan akun Anda terdaftar sebagai pembina UKM.');
            }

            // Get pending membership requests for this UKM
            $pendingRequests = UkmAnggota::with(['mahasiswa.user', 'ukm'])
                ->where('ukm_id', $pembina->ukm_id)
                ->pending()
                ->orderBy('created_at', 'desc')
                ->get();

            return view('ukm.member-requests', compact('pendingRequests', 'pembina'));
        } elseif ($user->peran === 'Admin') {
            // Admin can see all pending requests
            $pendingRequests = UkmAnggota::with(['mahasiswa.user', 'ukm'])
                ->pending()
                ->orderBy('created_at', 'desc')
                ->get();

            return view('ukm.member-requests', compact('pendingRequests'));
        }

        return redirect()->back()->with('error', 'Akses ditolak.');
    }

    /**
     * Apply for UKM membership (for mahasiswa)
     */
    public function apply(Request $request, Ukm $ukm)
    {
        $user = Auth::user();
        if ($user->peran !== 'Mahasiswa') {
            return redirect()->back()->with('error', 'Hanya mahasiswa yang dapat mendaftar ke UKM.');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Check if already applied or member
        $existingMembership = UkmAnggota::where('ukm_id', $ukm->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($existingMembership) {
            $status = $existingMembership->status;
            $message = match($status) {
                'pending' => 'Anda sudah mengajukan permohonan ke UKM ini. Menunggu persetujuan pembina.',
                'approved' => 'Anda sudah menjadi anggota UKM ini.',
                'rejected' => 'Permohonan Anda sebelumnya ditolak. Silakan hubungi pembina untuk informasi lebih lanjut.'
            };
            return redirect()->back()->with('info', $message);
        }

        try {
            DB::beginTransaction();

            UkmAnggota::create([
                'ukm_id' => $ukm->id,
                'mahasiswa_id' => $mahasiswa->id,
                'jabatan' => 'anggota',
                'is_active' => false, // Will be activated after approval
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Permohonan keanggotaan UKM berhasil diajukan. Menunggu persetujuan pembina.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengajukan permohonan.');
        }
    }

    /**
     * Approve membership request
     */
    public function approve(Request $request, UkmAnggota $ukmAnggota)
    {
        $user = Auth::user();

        if (!in_array($user->peran, ['UKM', 'Admin'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->peran === 'UKM') {
            $pembina = Pembina::where('user_id', $user->id)->first();

            if (!$pembina || $pembina->ukm_id !== $ukmAnggota->ukm_id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki wewenang untuk menyetujui permohonan ini.');
            }
        }

        if ($ukmAnggota->status !== 'pending') {
            return redirect()->back()->with('error', 'Permohonan ini sudah diproses sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $approvedBy = null;
            if ($user->peran === 'UKM') {
                $pembina = Pembina::where('user_id', $user->id)->first();
                $approvedBy = $pembina ? $pembina->id : null;
            }

            $ukmAnggota->update([
                'status' => 'approved',
                'is_active' => true,
                'approved_by' => $approvedBy,
                'approved_at' => now(),
                'approval_notes' => $request->input('notes')
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Permohonan keanggotaan berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui permohonan.');
        }
    }

    /**
     * Reject membership request
     */
    public function reject(Request $request, UkmAnggota $ukmAnggota)
    {
        $user = Auth::user();

        if (!in_array($user->peran, ['UKM', 'Admin'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->peran === 'UKM') {
            $pembina = Pembina::where('user_id', $user->id)->first();

            if (!$pembina || $pembina->ukm_id !== $ukmAnggota->ukm_id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki wewenang untuk menolak permohonan ini.');
            }
        }

        if ($ukmAnggota->status !== 'pending') {
            return redirect()->back()->with('error', 'Permohonan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $approvedBy = null;
            if ($user->peran === 'UKM') {
                $pembina = Pembina::where('user_id', $user->id)->first();
                $approvedBy = $pembina ? $pembina->id : null;
            }

            $ukmAnggota->update([
                'status' => 'rejected',
                'approved_by' => $approvedBy,
                'approved_at' => now(),
                'approval_notes' => $request->input('notes')
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Permohonan keanggotaan ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak permohonan.');
        }
    }
      /**
     * View available UKMs for mahasiswa to apply
     */
    public function availableUkms()
    {
        $user = Auth::user();

        if ($user->peran !== 'Mahasiswa') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Get all UKMs with their current membership status for this mahasiswa
        $ukms = Ukm::with(['pembina.user'])
            ->leftJoin('ukm_anggota', function($join) use ($mahasiswa) {
                $join->on('ukm.id', '=', 'ukm_anggota.ukm_id')
                     ->where('ukm_anggota.mahasiswa_id', $mahasiswa->id);
            })
            ->select('ukm.*', 'ukm_anggota.status as membership_status')
            ->get();

        return view('mahasiswa.ukm-list', compact('ukms'));
    }

    /**
     * View membership status for mahasiswa
     * Note: This feature has been removed from the sidebar menu but keeping the controller method
     * in case it's accessed directly via URL
     */
    public function myMemberships()
    {
        $user = Auth::user();

        // Since this feature is no longer accessible from menu for Mahasiswa role,
        // redirect to profile page where they can see their memberships
        if ($user->peran === 'Mahasiswa') {
            return redirect()->route('users.profile')->with('info', 'Informasi keanggotaan UKM sekarang tersedia di halaman profil Anda.');
        }

        if ($user->peran !== 'Mahasiswa') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $memberships = UkmAnggota::with(['ukm', 'approver.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.my-memberships', compact('memberships'));
    }
}
