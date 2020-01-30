<?php

namespace Imanghafoori\TokenizedLogin\TokenGenerators;

class TokenGenerator
{
    function generateToken()
    {
        return random_int(100000, 1000000 - 1);
    }
}
