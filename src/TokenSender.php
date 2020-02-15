<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Notification;

class TokenSender
{
    public function send($user, $token)
    {
        $notif = new LoginTokenNotification($token);

        Notification::sendNow($user, $notif);
    }
}
