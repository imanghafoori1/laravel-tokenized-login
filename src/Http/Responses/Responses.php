<?php

namespace Imanghafoori\TokenizedLogin\Http\Responses;

use Illuminate\Http\Response;

class Responses
{
    public function tokenNotFound()
    {
        return response()->json(['message' => 'Token is not valid']);
    }

    public function loggedIn()
    {
        return response()->json(['message' => 'You are logged in']);
    }

    public function youShouldBeGuest()
    {
        return response()->json([
            'error' => 'you are logged in', Response::HTTP_BAD_REQUEST
        ]);
    }

    public function emailNotValid()
    {
        return response()->json([
            'error' => 'your email is not valid', Response::HTTP_BAD_REQUEST
        ]);
    }

    public function blockedUser()
    {
        return response()->json(
            ['error' => 'You are blocked'], Response::HTTP_BAD_REQUEST
        );
    }

    public function tokenSent()
    {
        return response()->json(['message' => 'token was sent.']);
    }

    public function userNotFound()
    {
        return response()->json(
            ['error' => 'Email Does not Exist'], Response::HTTP_BAD_REQUEST
        );
    }
}







