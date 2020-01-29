<?php

namespace Imanghafoori\TwoFactorAuth\Authenticator;

use Illuminate\Support\Facades\Auth;

class SessionAuth
{
    public function check()
    {
        return Auth::check();
    }

    public function loginById($uid)
    {
        auth()->loginUsingId($uid);
    }
}
