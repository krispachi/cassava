<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanUKMController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\UkmMemberController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TAKController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name("home.index");


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Pusat Informasi
    Route::get('/pusat-informasi', function() {
        return view('informasi.index');
    })->name("pusat-informasi.index");

    // Admin Dashboard Routes - No middleware, admin can access everything
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/ukm-management', [AdminDashboardController::class, 'manageUkm'])->name('admin.ukm-management');
    Route::get('/admin/ukm/create', [AdminDashboardController::class, 'createUkm'])->name('admin.ukm.create');
    Route::post('/admin/ukm', [AdminDashboardController::class, 'storeUkm'])->name('admin.ukm.store');
    Route::get('/admin/ukm/{ukm}/edit', [AdminDashboardController::class, 'editUkm'])->name('admin.ukm.edit');
    Route::put('/admin/ukm/{ukm}', [AdminDashboardController::class, 'updateUkm'])->name('admin.ukm.update');
    Route::delete('/admin/ukm/{ukm}', [AdminDashboardController::class, 'deleteUkm'])->name('admin.ukm.delete');
    Route::post('/admin/memberships/{membership}/approve', [AdminDashboardController::class, 'approveMembership'])->name('admin.memberships.approve');
    Route::post('/admin/memberships/{membership}/reject', [AdminDashboardController::class, 'rejectMembership'])->name('admin.memberships.reject');

    // Resource routes - Admin can access everything
    Route::resource('users', UserController::class);
    Route::get("/profile", [UserController::class, "profile"])->name("users.profile");
    Route::get("/profile/{id}", [UserController::class, "profile"])->name("users.profile.show");

    // TAK Routes
    Route::resource('tak', TAKController::class);

    // Sync Routes
    Route::get('/sync/user-mahasiswa', [App\Http\Controllers\SyncController::class, 'syncUserMahasiswa'])->name('sync.user-mahasiswa');
    Route::get('/sync/tak-points', [App\Http\Controllers\SyncController::class, 'updateAllTAKPoints'])->name('sync.tak-points');

    // Kegiatan UKM (Legacy) - Admin only
    Route::middleware('can:admin-only')->group(function () {
        Route::get("/kegiatan-ukm/riwayat", [KegiatanUKMController::class, "riwayat"])->name("kegiatan-ukm.riwayat.index");
        Route::resource("kegiatan-ukm", KegiatanUKMController::class);
    });

    // UKM Routes
    Route::resource('ukm', UkmController::class);
    Route::post('ukm/{ukm}/join', [UkmController::class, 'join'])->name('ukm.join');
    Route::post('ukm/{ukm}/leave', [UkmController::class, 'leave'])->name('ukm.leave');

    // UKM Membership Routes - Role-based access
    Route::middleware('can:ukm-only')->group(function () {
        Route::get('/ukm-memberships/requests', [UkmMemberController::class, 'index'])->name('ukm.member-requests');
        Route::post('/ukm-membership/{ukmAnggota}/approve', [UkmMemberController::class, 'approve'])->name('ukm.membership.approve');
        Route::post('/ukm-membership/{ukmAnggota}/reject', [UkmMemberController::class, 'reject'])->name('ukm.membership.reject');
    });

    Route::middleware('can:mahasiswa-only')->group(function () {
        Route::post('/ukm/{ukm}/apply', [UkmMemberController::class, 'apply'])->name('ukm.apply');
        Route::get('/available-ukms', [UkmMemberController::class, 'availableUkms'])->name('mahasiswa.available-ukms');
        Route::get('/my-memberships', [UkmMemberController::class, 'myMemberships'])->name('mahasiswa.my-memberships');
    });

    // Kegiatan Routes
    Route::resource('kegiatan', KegiatanController::class);
    Route::post('kegiatan/{kegiatan}/absen', [KegiatanController::class, 'absen'])->name('kegiatan.absen');
    Route::get('kegiatan/{kegiatan}/peserta', [KegiatanController::class, 'peserta'])->name('kegiatan.peserta');
    Route::post('kegiatan/{kegiatan}/refresh-qrcode', [KegiatanController::class, 'refreshQrCode'])->name('kegiatan.refresh-qrcode');
});

