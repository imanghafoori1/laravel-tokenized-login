<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Notification;

class TokenSender
{
    public function send($token, $user)
    {
        $notification = new LoginTokenNotification($token);

        Notification::sendNow($user, $notification);
    }
}
