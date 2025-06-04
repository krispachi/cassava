<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\UkmAnggota;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UkmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ukms = Ukm::all();
        $user = Auth::user();

        if ($user->isMahasiswa() && $user->mahasiswa) {
            // Ambil UKM yang diikuti oleh mahasiswa (hanya yang status approved dan is_active=1)
            $mahasiswaId = $user->mahasiswa->id;
            $joinedUkms = UkmAnggota::where('mahasiswa_id', $mahasiswaId)
                ->where('status', 'approved')
                ->where('is_active', 1)
                ->pluck('ukm_id')
                ->toArray();

            // Get UKMs with pending membership requests
            $pendingUkms = UkmAnggota::where('mahasiswa_id', $mahasiswaId)
                ->where('status', 'pending')
                ->pluck('ukm_id')
                ->toArray();
        } else {
            $joinedUkms = [];
            $pendingUkms = [];
        }

        return view('ukm.index', compact('ukms', 'joinedUkms', 'pendingUkms', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya admin yang bisa membuat UKM
        if (Auth::user()->peran !== 'Admin') {
            return redirect()->route('ukm.index')->with('error', 'Anda tidak memiliki izin untuk membuat UKM baru');
        }

        return view('ukm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya admin yang bisa membuat UKM
        if (Auth::user()->peran !== 'Admin') {
            return redirect()->route('ukm.index')->with('error', 'Anda tidak memiliki izin untuk membuat UKM baru');
        }

        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('ukm-logos', 'public');
            $validated['logo'] = $logoPath;
        }

        Ukm::create($validated);

        return redirect()->route('ukm.index')->with('success', 'UKM berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ukm $ukm)
    {
        $user = Auth::user();
        $isMember = false;
        $isPending = false;
        $isAdmin = false;

        if ($user->isMahasiswa() && $user->mahasiswa) {
            // Check if active member
            $isMember = UkmAnggota::where('ukm_id', $ukm->id)
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->where('status', 'approved')
                ->where('is_active', 1)
                ->exists();

            // Check if has pending request
            $isPending = UkmAnggota::where('ukm_id', $ukm->id)
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->where('status', 'pending')
                ->exists();
        }

        if ($user->peran === 'Admin') {
            $isAdmin = true;
        }

        $anggota = UkmAnggota::with('mahasiswa.user')
            ->where('ukm_id', $ukm->id)
            ->where('status', 'approved')
            ->where('is_active', 1)
            ->get();

        $kegiatan = $ukm->kegiatan()->latest()->get();

        return view('ukm.show', compact('ukm', 'isMember', 'isPending', 'isAdmin', 'anggota', 'kegiatan', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ukm $ukm)
    {
        // Hanya admin yang bisa edit UKM
        if (Auth::user()->peran !== 'Admin') {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Anda tidak memiliki izin untuk mengedit UKM');
        }

        return view('ukm.edit', compact('ukm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ukm $ukm)
    {
        // Hanya admin yang bisa update UKM
        if (Auth::user()->peran !== 'Admin') {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Anda tidak memiliki izin untuk mengedit UKM');
        }

        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
                Storage::disk('public')->delete($ukm->logo);
            }

            $logoPath = $request->file('logo')->store('ukm-logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $ukm->update($validated);

        return redirect()->route('ukm.show', $ukm)->with('success', 'UKM berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ukm $ukm)
    {
        // Hanya admin yang bisa hapus UKM
        if (Auth::user()->peran !== 'Admin') {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Anda tidak memiliki izin untuk menghapus UKM');
        }

        // Delete logo if exists
        if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
            Storage::disk('public')->delete($ukm->logo);
        }

        $ukm->delete();

        return redirect()->route('ukm.index')->with('success', 'UKM berhasil dihapus');
    }

    /**
     * Join UKM as a member
     */
    public function join(Request $request, Ukm $ukm)
    {
        $user = Auth::user();

        if (!$user->isMahasiswa()) {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Hanya mahasiswa yang dapat bergabung dengan UKM');
        }

        $mahasiswa = $user->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Profil mahasiswa Anda tidak ditemukan');
        }

        // Check if already a member or has a pending request
        $existingMembership = UkmAnggota::where('ukm_id', $ukm->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($existingMembership) {
            $status = $existingMembership->status;
            $message = match($status) {
                'pending' => 'Anda sudah mengajukan permohonan ke UKM ini. Menunggu persetujuan pembina.',
                'approved' => 'Anda sudah menjadi anggota UKM ini.',
                'rejected' => 'Permohonan Anda sebelumnya ditolak. Silakan hubungi pembina untuk informasi lebih lanjut.',
                default => 'Anda sudah terdaftar di UKM ini'
            };
            return redirect()->route('ukm.show', $ukm)->with('warning', $message);
        }

        // Create a pending membership request
        UkmAnggota::create([
            'ukm_id' => $ukm->id,
            'mahasiswa_id' => $mahasiswa->id,
            'jabatan' => 'anggota',
            'is_active' => 0,  // Will be activated after approval
            'status' => 'pending'
        ]);

        return redirect()->route('ukm.show', $ukm)->with('success', 'Permohonan keanggotaan berhasil diajukan. Menunggu persetujuan pembina.');
    }

    /**
     * Leave UKM
     */
    public function leave(Request $request, Ukm $ukm)
    {
        $user = Auth::user();

        if (!$user->isMahasiswa()) {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Fitur ini hanya untuk mahasiswa');
        }

        $mahasiswa = $user->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Profil mahasiswa Anda tidak ditemukan');
        }

        // Find the membership record
        $membership = UkmAnggota::where('ukm_id', $ukm->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if (!$membership) {
            return redirect()->route('ukm.show', $ukm)->with('error', 'Anda tidak terdaftar di UKM ini');
        }

        // If it's a pending request, delete it
        if ($membership->status === 'pending') {
            $membership->delete();
            return redirect()->route('ukm.show', $ukm)->with('success', 'Permohonan keanggotaan berhasil dibatalkan');
        }

        // If it's an approved membership, deactivate it
        $membership->update(['is_active' => 0]);

        return redirect()->route('ukm.index')->with('success', 'Anda telah keluar dari UKM');
    }
}
