<?php

namespace App\Providers;

use Laravel\Socialite\Two\AbstractProvider;
 
class SocialiteDgpProvider extends AbstractProvider
{
 
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getDgpUrl() . '/authorize', $state);
        // TODO: Implement getAuthUrl() method.
    }
 
    protected function getTokenUrl()
    {
        // TODO: Implement getTokenUrl() method.
    }
 
    protected function getUserByToken($token)
    {
        // TODO: Implement getUserByToken() method.
    }
 
    protected function mapUserToObject(array $user)
    {
        // TODO: Implement mapUserToObject() method.
    }

    public function getDgpUrl()
    {
        return config('services.DGP.base_uri') . '/oauth2';
    }

    
}
