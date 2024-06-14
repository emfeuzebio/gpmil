<?php

// namespace Laravel\Socialite\Two;
namespace App\Providers;

use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class DGPProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    // protected $scopes = ['user:email'];
    protected $scopes = ['INF_MIL_BASICO'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://acesso.dgp.eb.mil.br/authorize', $state);

    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://acesso.dgp.eb.mil.br/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            RequestOptions::FORM_PARAMS => $this->getTokenFields($token),
        ]);

        $data = json_decode($response->getBody(), true);

        return Arr::add($data, 'expires_in', Arr::pull($data, 'expires'));
    }

    /**
     * Get the email for the given access token.
     *
     * @param  string  $token
     * @return string|null
     */
    protected function getEmailByToken($token)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())
            ->setRaw($user)
            ->map([
                'id' => null,
                'nickname' => Arr::get($user, 'INF_MIL_BASICO.NOME_GUERRA'),
                'name' => Arr::get($user, 'INF_MIL_BASICO.NOME_MILITAR'),
                'email' => Arr::get($user, 'INF_MIL_BASICO.MILITAR_IDENTIDADE'),
                'avatar' => null,
                'idt' => Arr::get($user, 'INF_MIL_BASICO.MILITAR_IDENTIDADE'),
                'om_codom' => Arr::get($user, 'INF_MIL_BASICO.OM_CODOM'),
                'pgrad_sigla' => Arr::get($user, 'INF_MIL_BASICO.POSTO_GRADUACAO_SIGLA'),
            ]);
    }

    /**
     * Get the User instance for the authenticated user.
     *
     * @return UserInterface
     */

    /**
     * Get the default options for an HTTP request.
     *
     * @param  string  $token
     * @return array
     */
    protected function getRequestOptions($token)
    {
        return [
            RequestOptions::HEADERS => [
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => 'token '.$token,
            ],
        ];
    }
}