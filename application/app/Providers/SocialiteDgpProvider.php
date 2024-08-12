<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\DGPProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

class SocialiteDgpProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(SocialiteFactory $socialite)
    {
        $socialite->extend('DGP', function ($app) use ($socialite) {
            $config = $app['config']['services.DGP'];
            return $socialite->buildProvider(DGPProvider::class, $config);
        });
    }
}