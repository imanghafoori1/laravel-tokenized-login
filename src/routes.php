<?php

use Imanghafoori\TokenizedLogin\Http\Controllers\TokenSenderController;

Route::post(config('tokenized_login.route_prefix_url').'/request-token',
    [TokenSenderController::class, 'issueToken'])
    ->name('tokenized_login.requestToken')
    ->middleware(config('tokenized_login.throttler_middleware'));

Route::post(config('tokenized_login.route_prefix_url').'/login',
    [TokenSenderController::class, 'loginWithToken'])
    ->name('tokenized_login.login')
    ->middleware(config('tokenized_login.throttler_middleware'));