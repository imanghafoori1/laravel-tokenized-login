<?php

namespace Imanghafoori\TwoFactorAuth\TokenGenerators;

class FakeTokenGenerator
{
    function generateToken()
    {
        return 123456;
    }
}
