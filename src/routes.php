<?php

use App\User;
use Imanghafoori\TokenizedLogin\Facades\TokenStoreFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenSenderFacade;

Route::get(config('tokenized_login.route_prefix_url').'/request-token',
    'TokenSenderController@issueToken')
    ->name('tokenized_login.requestToken');


Route::get(config('tokenized_login.route_prefix_url').'/login',
    'TokenSenderController@loginWithToken')
    ->name('tokenized_login.login');


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
