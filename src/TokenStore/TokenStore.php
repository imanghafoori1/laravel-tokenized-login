<?php

namespace Imanghafoori\TwoFactorAuth\TokenStore;

class TokenStore
{
    function saveToken($token, $userId)
    {
        $ttl = config('two_factor_config.token_ttl');
        cache()->set($token.'_2factor_auth', $userId, $ttl);
    }

    function getUidByToken($token)
    {
        $uid = cache()->pull($token.'_2factor_auth');

        return nullable($uid);
    }
}
