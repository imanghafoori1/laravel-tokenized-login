<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Notification;

class TokenSender
{
    public function send($token, $user)
    {
        $notif = new LoginTokenNotification($token);

        Notification::sendNow($user, $notif);
    }
}
