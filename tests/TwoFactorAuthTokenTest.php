<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Foundation\Auth\User;
use Imanghafoori\TokenizedLogin\Facades\AuthFacade;
use Imanghafoori\TokenizedLogin\Http\ResponderFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenStoreFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenSenderFacade;
use Imanghafoori\TokenizedLogin\Facades\UserProviderFacade;
use Imanghafoori\TokenizedLogin\Facades\TokenGeneratorFacade;

class TwoFactorAuthTokenTest extends TestCase
{
    public function test_the_happy_path()
    {
        User::unguard();
        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1)
            ->andReturn(false);

        $user = new User(['id'=> 1, 'email' => 'iman@gmail.com']);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('iman@gmail.com')
            ->andReturn(nullable($user));
        // mock
        TokenGeneratorFacade::shouldReceive('generateToken')
            ->once()
            ->withNoArgs()
            ->andReturn('1q2w3e');

        TokenStoreFacade::shouldReceive('saveToken')->once()
            ->with('1q2w3e', $user->id);

        TokenSenderFacade::shouldReceive('send')->once()
            ->with('1q2w3e', $user);

        ResponderFacade::shouldReceive('tokenSent')->once();
        $this->get('tokenized-login/request-token?email=iman@gmail.com');
    }

    public function test_user_is_banned()
    {
        User::unguard();
        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1)
            ->andReturn(true);

        $user = new User(['id'=> 1, 'email' => 'iman@gmail.com']);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->andReturn(nullable($user));
        // mock
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();

        $respo = $this->get('tokenized-login/request-token?email=iman@gmail.com');
        $respo->assertStatus(400);
        $respo->assertJson(['error' => 'You are blocked']);
    }

    public function test_email_does_not_exist()
    {
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('iman@gmail.com')
            ->andReturn(nullable(null));
        // mock
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('userNotFound')->once()->andReturn(response('hello'));
        $resp = $this->get('tokenized-login/request-token?email=iman@gmail.com');
        $resp->assertSee('hello');
    }

    public function test_email_not_valid()
    {
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->never();
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('emailNotValid')->once()
            ->andReturn(response('hello'));
        $resp = $this->get('tokenized-login/request-token?email=iman_gmail.com');
        $resp->assertSee('hello');
    }

    public function test_user_is_guest()
    {
        AuthFacade::shouldReceive('check')->once()->andReturn(true);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->never();
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('youShouldBeGuest')->once()
            ->andReturn(response('hello'));
        $resp = $this->get('tokenized-login/request-token?email=iman@gmail.com');
        $resp->assertSee('hello');
    }
}






