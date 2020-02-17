<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Foundation\Auth\User;

class UserProvider
{
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return nullable($user);
    }

    public function isBanned($uid)
    {
        return false;
    }
}
