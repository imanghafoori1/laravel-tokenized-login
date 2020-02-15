<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\TokenizedLogin\Authenticator\SessionAuth;
use Imanghafoori\TokenizedLogin\Facades\AuthFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenGeneratorFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenSenderFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenStoreFacade;
use Imanghafoori\TokenizedLogin\Facades\UserProviderFacade;
use Imanghafoori\TokenizedLogin\Http\ResponderFacade;
use Imanghafoori\TokenizedLogin\TokenGenerators\FakeTokenGenerator;
use Imanghafoori\TokenizedLogin\TokenStore\FakeTokenStore;
use Imanghafoori\TokenizedLogin\TokenStore\TokenStore;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    private $namespace = 'Imanghafoori\TokenizedLogin\Http\Controllers';

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/tokenized_login.php', 'tokenized_login');
        AuthFacade::shouldProxyTo(SessionAuth::class);
        UserProviderFacade::shouldProxyTo(UserProvider::class);
        if (app()->runningUnitTests()) {
            $tokenGenerator = FakeTokenGenerator::class;
            $tokenStore = FakeTokenStore::class;
            $tokenSender = FakeTokenSender::class;
        } else {
            $tokenSender = config('tokenized_login.token_sender');
            $tokenGenerator = config('tokenized_login.token_generator');
            $tokenStore = TokenStore::class;
        }
        ResponderFacade::shouldProxyTo(config('tokenized_login.responses'));
        TokenGeneratorFacade::shouldProxyTo($tokenGenerator);
        TokenStoreFacade::shouldProxyTo($tokenStore);
        TokenSenderFacade::shouldProxyTo($tokenSender);
    }

    public function boot()
    {
        if (! $this->app->routesAreCached() && config('tokenized_login.use_default_routes')) {
            $this->defineRoutes();
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config' => $this->app->configPath(),
            ], 'tokenized_login');
        }
    }

    private function defineRoutes()
    {
        Route::middleware(config('tokenized_login.route_middlewares'))
            ->namespace($this->namespace)
            ->group(__DIR__.'./routes.php');
    }
}
