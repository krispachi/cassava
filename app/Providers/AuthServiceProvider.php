<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('envi-users', function ($user) {
            return $user->peran === 'Admin';
        });

        Gate::define('envi-tak', function ($user) {
            return in_array($user->peran, ['Admin', 'Mahasiswa']);
        });

        Gate::define('envi-ukm', function ($user) {
            return in_array($user->peran, ['Admin', 'UKM', 'Mahasiswa']);
        });

        Gate::define('envi-kegiatan-ukm', function ($user) {
            return $user->peran === 'Admin';
        });

        Gate::define('admin-only', function ($user) {
            return $user->peran === 'Admin';
        });

        Gate::define('mahasiswa-only', function ($user) {
            return $user->peran === 'Mahasiswa';
        });

        Gate::define('ukm-only', function ($user) {
            return $user->peran === 'UKM' || $user->peran === 'Admin';
        });
    }
}
