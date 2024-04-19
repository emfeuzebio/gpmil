<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Pgrad::class => PgradPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('is_encpes', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 3 ? true : false );
        });                

        Gate::define('is_admin', function (User $user) {
            //carrega o usuário e a pessoa correspondente
            $user = User::with('pessoa')->find(Auth::user()->id);
            // dd($user->pessoa);
            // dd($user->pessoa->nome_completo);
            // dd($user->pessoa->nivelacesso_id);
            return ( $user->pessoa->nivelacesso_id == 1 ? true : false );
        });        

        Gate::define('is_cmt', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 2 ? true : false );
        });        

        Gate::define('is_chesec', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            $user->name = $user->pessoa->nome_guerra;
            return ( $user->pessoa->nivelacesso_id == 4 ? true : false );
        });                        

        Gate::define('is_sgtte', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 5 ? true : false );
        });                        

        Gate::define('is_usuario', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 6 ? true : false );
        });                        

    }
}
