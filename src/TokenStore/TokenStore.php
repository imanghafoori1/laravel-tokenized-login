<?php

namespace Imanghafoori\TokenizedLogin\TokenStore;

class TokenStore
{
    function saveToken($token, $userId)
    {
        $ttl = config('tokenized_login.token_ttl');
        cache()->set($token.'_2factor_auth', $userId, now()->addSeconds($ttl));
    }

    function getUidByToken($token)
    {
        $uid = cache()->pull($token.'_2factor_auth');

        return nullable($uid);
    }
}
