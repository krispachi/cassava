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
    }
}