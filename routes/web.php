<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanUKMController;
use App\Http\Controllers\TAKController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name("home.index");

Route::get('/dashboard', function() {
    return view("dashboard.index");
})->name("dashboard.index");

Route::get('/pusat-informasi', function() {
    echo "Halo";
})->name("pusat-informasi.index");

Route::resource("/tak", TAKController::class);
Route::resource("/kegiatan-ukm", KegiatanUKMController::class);
Route::resource("/user", UserController::class);

Route::get("/user/profile", [UserController::class, "profile"])->name("user.profile");
Route::get("/kegiatan-ukm/riwayat", [KegiatanUKMController::class, "riwayat"])->name("kegiatan-ukm.riwayat.index");
Route::post("/logout", [AuthController::class, "logout"])->name("auth.logout");
