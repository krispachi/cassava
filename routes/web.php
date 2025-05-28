<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanUKMController;
use App\Http\Controllers\TAKController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name("home.index");


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');

    // Resource routes dengan gate authorization
    Route::resource('users', UserController::class)->middleware('can:envi-users');
    Route::resource('tak', TAKController::class)->middleware('can:envi-tak');
    Route::resource('kegiatan-ukm', KegiatanUKMController::class)->middleware('can:envi-ukm');
});



Route::get('/pusat-informasi', function() {
    echo "Halo";
})->name("pusat-informasi.index");

Route::resource("/tak", TAKController::class);
Route::resource("/kegiatan-ukm", KegiatanUKMController::class);

Route::get("/profile", [UserController::class, "profile"])->name("users.profile");
Route::get("/users/{id}/profile", [UserController::class, "profile"])->name("users.profile.show");
Route::resource("/users", UserController::class);

Route::get("/kegiatan-ukm/riwayat", [KegiatanUKMController::class, "riwayat"])->name("kegiatan-ukm.riwayat.index");

