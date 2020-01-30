<?php

Route::get(config('tokenized_login.route_prefix_url').'/request-token',
    'TokenSenderController@issueToken')
    ->name('tokenized_login.requestToken');


Route::get(config('tokenized_login.route_prefix_url').'/login',
    'TokenSenderController@loginWithToken')
    ->name('tokenized_login.login');
