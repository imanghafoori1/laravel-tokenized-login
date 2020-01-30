<?php

namespace Imanghafoori\TokenizedLogin;

use Illuminate\Support\Facades\Notification;

class TokenSender
{
    public function send($user, $token)
    {
        $class = config('tokenized_login.notification_class');
        Notification::sendNow($user, new $class($token));
    }
}
