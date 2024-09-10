<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\DB;


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

        /**
         * Nível de acesso 1 = Administrador - is_admin - Pode tudão inclusive em configurações gerais
         * Nível de acesso 2 = Comandante - is_cmt - Pode Ver tudão e editar seus dados
         * Nível de acesso 3 = Enc Pessoal - is_encpes - Pode tudão, com restrições em configurações gerais
         * Nível de acesso 4 = Ch Seç - is_chsec - Pode Ver tudo do pessoal de sua Seç e editar seus dados
         * Nível de acesso 5 = Sgtte - is_sgtte - Pode Editar tudo do pessoal de sua Seç e editar seus dados
         * Nível de acesso 6 = Usuário - is_usuario - Pode apenas Editar seus dados
         */

        Gate::define('is_admin', function (User $user) {
            //carrega o usuário e a pessoa correspondente
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 1 ? true : false );
        });        

        Gate::define('is_cmt', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 2 ? true : false );
        });        

        Gate::define('is_encpes', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return ( $user->pessoa->nivelacesso_id == 3 ? true : false );
        });                

        Gate::define('is_chsec', function (User $user) {
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

        Gate::define('podeEditarPlanoChamada', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return in_array($user->pessoa->nivelacesso_id,[1,3,5,6]);
            // return in_array($user->pessoa->nivelacesso_id,[1]);
        });                        

        Gate::define('podeSalvarPessoa', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return in_array($user->pessoa->nivelacesso_id,[1,3,5,6]);
        });

        Gate::define('podeSalvarSecao', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return in_array($user->pessoa->nivelacesso_id,[1,3,5,6]);
        });

        Gate::define('soVer', function (User $user) {
            $user = User::with('pessoa')->find(Auth::user()->id);
            return in_array($user->pessoa->nivelacesso_id,[2,4]);
        });

        Gate::define('temSolicitacaoSecao', function (User $user) {

            return DB::table('notifications')
                        ->where('read_at', null)
                        ->where('data->tipo', 'secao')
                        ->where('data->user_id', $user->id)
                        ->exists();

        });

        Gate::define('temSolicitacaoNivelAcesso', function ($user) {
            return DB::table('notifications')
                        ->where('read_at', null)
                        ->where('data->tipo', 'nivel_acesso')
                        ->where('data->user_id', $user->id)
                        ->exists();
        });
        
        Gate::define('temSolicitacaoStatus', function ($user) {
            return DB::table('notifications')
                        ->where('read_at', null)
                        ->where('data->tipo', 'status')
                        ->where('data->user_id', $user->id)
                        ->exists();
        });
        

    }
}
