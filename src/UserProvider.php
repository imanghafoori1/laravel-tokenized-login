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
        $user = User::find($uid) ?: new User();

        return $user->is_ban == 1 ? true : false;
    }
}
