<?php

namespace Imanghafoori\TokenizedLogin;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Imanghafoori\TokenizedLogin\TwoFactorAuthServiceProvider::class];
    }
}
