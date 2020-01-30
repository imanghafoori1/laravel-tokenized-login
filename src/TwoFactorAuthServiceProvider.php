<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Route;
use Imanghafoori\TokenizedLogin\Facades\AuthFacade;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\TokenizedLogin\Http\ResponderFacade;
use Imanghafoori\TokenizedLogin\TokenStore\TokenStore;
use Imanghafoori\TokenizedLogin\Facades\TokenStoreFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenSenderFacade;
use Imanghafoori\TokenizedLogin\Authenticator\SessionAuth;
use Imanghafoori\TokenizedLogin\TokenStore\FakeTokenStore;
use Imanghafoori\TokenizedLogin\Facades\UserProviderFacade;
use Imanghafoori\TokenizedLogin\Http\Responses\Responses;
use Imanghafoori\TokenizedLogin\Facades\TokenGeneratorFacade;
use Imanghafoori\TokenizedLogin\TokenGenerators\TokenGenerator;
use Imanghafoori\TokenizedLogin\TokenGenerators\FakeTokenGenerator;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    private $namespace = 'Imanghafoori\TokenizedLogin\Http\Controllers';

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/tokenized_login.php', 'tokenized_login');
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

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config' => $this->app->configPath()
            ], 'tokenized_login');
        }
    }

    private function defineRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'./routes.php');
    }
}
