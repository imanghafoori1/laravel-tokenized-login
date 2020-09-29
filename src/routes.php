<?php

Route::post(config('tokenized_login.route_prefix_url').'/request-token',
    'TokenSenderController@issueToken')
    ->name('tokenized_login.requestToken')
    ->middleware(config('tokenized_login.throttler_middleware'));

Route::post(config('tokenized_login.route_prefix_url').'/login',
    'TokenSenderController@loginWithToken')
    ->name('tokenized_login.login')
    ->middleware(config('tokenized_login.throttler_middleware'));
