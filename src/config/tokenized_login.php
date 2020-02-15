<?php

return [
    /**
     * The life time of tokens in seconds.
     */
    'token_ttl' => 120,

    'use_default_routes' => true,

    'route_middlewares' => ['api'],
    /**
     * Route prefix for token stuff.
     * Note: it should not end in a slash character.
     */
    'route_prefix_url' => '/tokenized-login',

    /**
     * Notification class used to send the token to user.
     */
    'token_sender' => \Imanghafoori\TokenizedLogin\TokenSender::class,
];
