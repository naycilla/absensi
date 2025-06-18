<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('sekretaris', function($user) {
            if(request()->is('sekretaris/*') )
            return $user->level == 2 ;
        });

        Gate::define('operator', function($user) {
            if(request()->is('operator/*') )
            return $user->level == 3;
        });

        Gate::define('siswa', function($user) {
            if(request()->is('siswa/*') )
            return in_array($user->level, [1, 2]);
        });

        Gate::define('admin', function($user) {
            if(request()->is('admin/*') )
            return $user->level == 4;
        });
    }
}
