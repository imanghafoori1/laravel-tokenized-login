<?php

namespace Imanghafoori\TwoFactorAuth;

use Illuminate\Support\Facades\Route;
use Imanghafoori\TwoFactorAuth\Facades\AuthFacade;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\TwoFactorAuth\Http\ResponderFacade;
use Imanghafoori\TwoFactorAuth\TokenStore\TokenStore;
use Imanghafoori\TwoFactorAuth\Facades\TokenStoreFacade;
use Imanghafoori\TwoFactorAuth\Facades\TokenSenderFacade;
use Imanghafoori\TwoFactorAuth\Authenticator\SessionAuth;
use Imanghafoori\TwoFactorAuth\TokenStore\FakeTokenStore;
use Imanghafoori\TwoFactorAuth\Facades\UserProviderFacade;
use Imanghafoori\TwoFactorAuth\Http\Responses\Responses;
use Imanghafoori\TwoFactorAuth\Facades\TokenGeneratorFacade;
use Imanghafoori\TwoFactorAuth\TokenGenerators\TokenGenerator;
use Imanghafoori\TwoFactorAuth\TokenGenerators\FakeTokenGenerator;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    private $namespace = 'Imanghafoori\TwoFactorAuth\Http\Controllers';

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/two_factor_auth_config.php',
            'two_factor_config'
        );

        AuthFacade::shouldProxyTo(SessionAuth::class);
        UserProviderFacade::shouldProxyTo(UserProvider::class);
        if (app()->runningUnitTests()) {
            $tokenGenerator = FakeTokenGenerator::class;
            $tokenStore = FakeTokenStore::class;
            $tokenSender = FakeTokenSender::class;
        } else {
            $tokenSender = TokenSender::class;
            $tokenGenerator = TokenGenerator::class;
            $tokenStore = TokenStore::class;
        }
        ResponderFacade::shouldProxyTo(Responses::class);
        TokenGeneratorFacade::shouldProxyTo($tokenGenerator);
        TokenStoreFacade::shouldProxyTo($tokenStore);
        TokenSenderFacade::shouldProxyTo($tokenSender);

    }

    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            $this->defineRoutes();
        }
    }

    private function defineRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'./routes.php');
    }
}
