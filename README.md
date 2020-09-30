

# Two factor authentication in Laravel

[![Monthly Downloads](https://poser.pugx.org/imanghafoori/laravel-tokenize-login/d/monthly)](https://packagist.org/packages/imanghafoori/laravel-tokenize-login)
[![Total Downloads](https://poser.pugx.org/imanghafoori/laravel-tokenize-login/downloads)](https://packagist.org/packages/imanghafoori/laravel-tokenize-login)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-tokenize-login/v/stable)](https://packagist.org/packages/imanghafoori/laravel-tokenize-login)
[![Build Status](https://travis-ci.org/imanghafoori1/laravel-tokenized-login.svg?branch=master)](https://travis-ci.org/imanghafoori1/laravel-tokenized-login)
<a href="https://scrutinizer-ci.com/g/imanghafoori1/tokenized-login"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/tokenized-login.svg?style=flat-square" alt="Quality Score"></img></a>
[![StyleCI](https://github.styleci.io/repos/237041801/shield?branch=master)](https://github.styleci.io/repos/237041801)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=round-square)](LICENSE.md)

This package creates an auto-expiring single-use 6 digit token, which you can send it (can be SMS, email, slack, etc ) to your users and they can login into their account with that token by just sending it back to an endpoint, which is also provided out of the box.

Exactly like alternate login method in Instagram.

You have complete control on how things will happen and you are free to swap the default implementations with your own.

# Installation
```
composer require imanghafoori/laravel-tokenize-login
```
Then publish the config file:

```
php artisan vendor:publish
```



# Basic usage:
Basically, this package introduces 2 endpoints, which you can send requests to them.

1. The first one is to generate and send the token to the user
```php
POST '/tokenized-login/request-token?email=iman@example.com'
```

2. The second one accepts the token and authoenticates the user if the token was valid.
```php
POST '/tokenized-login/login?email=iman@example.com'
```

Note: If you are not happy with the shape if the urls, you are free to cancel these out, and redefine them where ever you want.
you can take a look at the source code to find the controllers they refer to.

To disable the default routes you may set: ```'use_default_routes' => false,``` in the tokenized_login config file.

# Customization:
You can do a lot of customization and swap the default classes, with your own altenatives since we use the larave-smart-facade package.
Visit the config file to see what you can change.

If you want to swap the default implementations behind the facades with your own, you can do it within the `boot` method of any service provider class like this :

```php
    /**
     * The life time of tokens in seconds.
     */
    'token_ttl' => 120,

    /**
     * The rules to validate the the receiver address.
     * Usually it is an email address, but maybe a phone number.
     */
    'address_validation_rules' => ['required', 'email'],

    /**
     * Here you determine if you are ok with using the routes
     * defined within the package or you want to define them.
     */
    'use_default_routes' => true,

    /**
     * Here you can specify the middlewares to be applied on
     * the routes, which the package has provided for you.
     */
    'route_middlewares' => ['api'],

    /**
     * You can define a prefix for the urls to avoid conflicts.
     * Note: the prefix should NOT end in a slash / character.
     */
    'route_prefix_url' => '/tokenized-login',

    /**
     * Notification class used to send the token.
     * You may define your own token sender class.
     */
    'token_sender' => \Imanghafoori\TokenizedLogin\TokenSender::class,

    /**
     * You can change the way you generate the token by define you own class.
     */
    'token_generator' => \Imanghafoori\TokenizedLogin\TokenGenerators\TokenGenerator::class,

    /**
     * You can extend Responses class and override
     * it's methods, to define your own responses.
     */
    'responses' => \Imanghafoori\TokenizedLogin\Http\Responses\Responses::class,

    /**
     * You can change the way you fetch the user from your database
     * by defining a custom user provider class, and set it here.
     */
    'user_provider' => \Imanghafoori\TokenizedLogin\UserProvider::class,

    /**
     * You may provide a middleware throttler to throttle
     * the requesting and submission of the tokens.
     */
    'throttler_middleware' => 'throttle:3,1',

```
All the facades have a `shouldProxyTo` method which you can call, but remember not to do it within the `register` method, but only in `boot`.

--------------------

### :raising_hand: Contributing 
If you find an issue, or have a better way to do something, feel free to open an issue or a pull request.
If you use laravel-widgetize in your open source project, create a pull request to provide it's url as a sample application in the README.md file. 


### :exclamation: Security
If you discover any security related issues, please use the `security tab` instead of using the issue tracker.


### :star: Your Stars Make Us Do More :star:
As always if you found this package useful and you want to encourage us to maintain and work on it. Just press the star button to declare your willing.


## More from the author:


###  Laravel middlewarize

:gem: You can put middleware on any method calls.

- https://github.com/imanghafoori1/laravel-middlewarize

-------------

### Laravel HeyMan

:gem: It allows to write expressive code to authorize, validate and authenticate.

- https://github.com/imanghafoori1/laravel-heyman


--------------

### Laravel Terminator


 :gem: A minimal yet powerful package to give you opportunity to refactor your controllers.

- https://github.com/imanghafoori1/laravel-terminator


------------

