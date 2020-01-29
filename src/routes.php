<?php

use App\User;
use Imanghafoori\TwoFactorAuth\Facades\TokenStoreFacade;
use Imanghafoori\TwoFactorAuth\Facades\TokenSenderFacade;

Route::get('/two-factor-auth/request-token',
    'TokenSenderController@issueToken')
    ->name('2factor.requestToken');


Route::get('/two-factor-auth/login',
    'TokenSenderController@loginWithToken')
    ->name('2factor.login');


if (app()->environment('local')) {
    Route::get('test/token-notif', function () {
        User::unguard();
        $data = ['id' => 1, 'email' => 'imanghafoori1@gmail.com'];
        $user = new User($data);
        TokenSenderFacade::send($user, '123456');
    });

    Route::get('test/token-storage', function () {
        config()->set('two_factor_config.token_ttl', 3);

        TokenStoreFacade::saveToken('1q2w3e', 1);
        sleep(1);
        $uid = TokenStoreFacade::getUidByToken('1q2w3e')->getOr(null);

        if ($uid != 1) {
            dd('some problem with reading');
        }

        $uid = TokenStoreFacade::getUidByToken('1q2w3e')->getOr(null);

        if (! is_null($uid)) {
            dd('some problem with reading');
        }

        config()->set('two_factor_config.token_ttl', 1);

        TokenStoreFacade::saveToken('1q2w3e', 1);
        sleep(1.1);

        $uid = TokenStoreFacade::getUidByToken('1q2w3e')->getOr(null);

        if (! is_null($uid)) {
            dd('some problem with reading');
        }

        dd('cache store seems to be ok');
    });
}
