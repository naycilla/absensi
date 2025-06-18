<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('sekretaris', function($user) {
            if($user->level == 2) return $user->sekretaris;
        });

        Gate::define('operator', function($user) {
            if($user->level == 3 && request()->is('operator/*')) return $user->operator;
        });

        Gate::define('siswa', function($user) {
            if($user->level == 1 || $user->level = 2 && request()->is('siswa/*')) return $user->siswa;
        });

        Gate::define('admin', function($user) {
            if($user->level == 4) return $user->admin;
        });
    }
}
