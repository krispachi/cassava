<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Ukm;
use App\Models\Mahasiswa;
use App\Models\Absensi;
use App\Models\UkmAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek peran user
        $user = Auth::user();

        if ($user->isPembina()) {
            // Jika pembina, tampilkan kegiatan UKM yang dikelola
            $pembina = $user->pembina;
            if (!$pembina) {
                return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai pembina UKM');
            }

            $kegiatan = Kegiatan::where('ukm_id', $pembina->ukm_id)->latest()->get();
            return view('kegiatan.index', compact('kegiatan', 'user'));
        } else if ($user->isMahasiswa()) {
            // Jika mahasiswa, tampilkan kegiatan dari UKM yang diikuti
            $mahasiswa = $user->mahasiswa;
            if (!$mahasiswa) {
                return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai mahasiswa');
            }

            // Get UKM ID yang diikuti
            $ukmIds = $mahasiswa->ukm()->pluck('ukm.id')->toArray();
            $kegiatan = Kegiatan::whereIn('ukm_id', $ukmIds)->latest()->get();
            return view('kegiatan.index', compact('kegiatan', 'user'));
        }

        // Jika admin atau peran lain, tampilkan semua kegiatan
        $kegiatan = Kegiatan::latest()->get();
        return view('kegiatan.index', compact('kegiatan', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya pembina yang bisa membuat kegiatan
        $user = Auth::user();
        if (!$user->isPembina()) {
            return redirect()->route('kegiatan.index')->with('error', 'Anda tidak memiliki akses untuk membuat kegiatan');
        }

        $pembina = $user->pembina;
        if (!$pembina) {
            return redirect()->route('kegiatan.index')->with('error', 'Anda belum terdaftar sebagai pembina UKM');
        }

        $ukm = Ukm::find($pembina->ukm_id);
        return view('kegiatan.create', compact('ukm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'ukm_id' => 'required|exists:ukm,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:255',
            'poin_tak' => 'required|numeric|min:0',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        // Generate QR code with a unique value (shorter and easier to type manually if needed)
        $qrCodeValue = strtoupper(Str::random(8)) . '-' . time();
        $validatedData['qr_code'] = $qrCodeValue;

        // Create kegiatan
        $kegiatan = Kegiatan::create($validatedData);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        $isAttended = false;

        if ($user->isMahasiswa() && $user->mahasiswa) {
            $isAttended = $kegiatan->isAttendedBy($user->mahasiswa->id);
        }

        return view('kegiatan.show', compact('kegiatan', 'user', 'isAttended'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        // Hanya pembina dari UKM yang bersangkutan yang bisa edit
        $user = Auth::user();
        if (!$user->isPembina()) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk mengedit kegiatan');
        }

        $pembina = $user->pembina;
        if (!$pembina || $pembina->ukm_id != $kegiatan->ukm_id) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk mengedit kegiatan ini');
        }

        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        // Validasi
        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:255',
            'poin_tak' => 'required|numeric|min:0',
            'status' => 'required|in:draft,aktif,selesai',
            'generate_new_qr' => 'nullable|boolean',
        ]);

        // If requested, generate a new QR code
        if ($request->has('generate_new_qr') && $request->generate_new_qr) {
            $qrCodeValue = strtoupper(Str::random(8)) . '-' . time();
            $validatedData['qr_code'] = $qrCodeValue;
        }

        // Remove generate_new_qr from validated data before update
        if (isset($validatedData['generate_new_qr'])) {
            unset($validatedData['generate_new_qr']);
        }

        // Update kegiatan
        $kegiatan->update($validatedData);

        return redirect()->route('kegiatan.show', $kegiatan)->with('success', 'Kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // Hanya pembina dari UKM yang bersangkutan yang bisa hapus
        $user = Auth::user();
        if (!$user->isPembina()) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk menghapus kegiatan');
        }

        $pembina = $user->pembina;
        if (!$pembina || $pembina->ukm_id != $kegiatan->ukm_id) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk menghapus kegiatan ini');
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }

    /**
     * Absen kegiatan untuk mahasiswa
     */
    public function absen(Request $request, Kegiatan $kegiatan)
    {
        $user = Auth::user();
        if (!$user->isMahasiswa()) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Hanya mahasiswa yang dapat melakukan absensi');
        }

        $mahasiswa = $user->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda belum terdaftar sebagai mahasiswa');
        }

        // Cek status kegiatan
        if ($kegiatan->status !== 'aktif') {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Kegiatan tidak dalam status aktif untuk absensi');
        }

        // Validasi QR code
        $qrCode = $request->input('qr_code');
        if (empty($qrCode)) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Kode QR tidak boleh kosong');
        }

        // Trim any whitespace from QR code
        $qrCode = trim($qrCode);

        if ($kegiatan->qr_code !== $qrCode) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Kode QR tidak valid. Silakan scan ulang atau masukkan kode yang benar');
        }

        // Cek apakah sudah absen
        $exists = Absensi::where('kegiatan_id', $kegiatan->id)
                        ->where('mahasiswa_id', $mahasiswa->id)
                        ->exists();

        if ($exists) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('warning', 'Anda sudah melakukan absensi pada kegiatan ini');
        }

        // Cek apakah mahasiswa adalah anggota UKM
        $isMember = UkmAnggota::where('ukm_id', $kegiatan->ukm_id)
                            ->where('mahasiswa_id', $mahasiswa->id)
                            ->where('is_active', 1)
                            ->exists();

        if (!$isMember) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('warning', 'Anda belum menjadi anggota UKM ini. Silakan bergabung terlebih dahulu.');
        }

        // Simpan absensi
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'mahasiswa_id' => $mahasiswa->id,
            'waktu_absen' => now(),
            'status' => 'hadir'
        ]);

        // Update poin TAK mahasiswa
        $user->increment('poin_tak', $kegiatan->poin_tak);

        return redirect()->route('kegiatan.show', $kegiatan)->with('success', 'Absensi berhasil! Anda mendapatkan ' . $kegiatan->poin_tak . ' poin TAK');
    }

    /**
     * Lihat peserta kegiatan (untuk pembina)
     */
    public function peserta(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        if (!$user->isPembina()) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk melihat peserta');
        }

        $pembina = $user->pembina;
        if (!$pembina || $pembina->ukm_id != $kegiatan->ukm_id) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk melihat peserta kegiatan ini');
        }

        $peserta = Absensi::with('mahasiswa.user')
                        ->where('kegiatan_id', $kegiatan->id)
                        ->get();

        return view('kegiatan.peserta', compact('kegiatan', 'peserta'));
    }

    /**
     * Refresh QR Code for a kegiatan
     */
    public function refreshQrCode(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        if (!$user->isPembina()) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk memperbaharui QR Code');
        }

        $pembina = $user->pembina;
        if (!$pembina || $pembina->ukm_id != $kegiatan->ukm_id) {
            return redirect()->route('kegiatan.show', $kegiatan)->with('error', 'Anda tidak memiliki akses untuk memperbaharui QR Code kegiatan ini');
        }

        // Generate new QR code
        $qrCodeValue = strtoupper(Str::random(8)) . '-' . time();
        $kegiatan->update(['qr_code' => $qrCodeValue]);

        return redirect()->route('kegiatan.show', $kegiatan)->with('success', 'QR Code berhasil diperbaharui');
    }
}
