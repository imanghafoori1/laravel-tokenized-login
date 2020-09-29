<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Foundation\Auth\User;

class UserProvider
{
    /**
     * You may also accept user's phone number to send the code via sms.
     *
     * @param $address
     *
     * @return \Imanghafoori\Helpers\Nullable
     */
    public function getUserByEmail($address)
    {
        $user = User::query()->where('email', $address)->first();

        return nullable($user);
    }

    public function isBanned($uid)
    {
        return false;
    }
}
