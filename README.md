

# Two factor authentication in Laravel

[![Monthly Downloads](https://poser.pugx.org/imanghafoori/laravel-tokenized-login/d/monthly)](https://packagist.org/packages/imanghafoori/laravel-tokenized-login)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-tokenized-login/v/stable)](https://packagist.org/packages/imanghafoori/laravel-tokenized-login)
[![Build Status](https://travis-ci.org/imanghafoori1/tokenized-login.svg?branch=master)](https://travis-ci.org/imanghafoori1/tokenized-login)
<a href="https://scrutinizer-ci.com/g/imanghafoori1/tokenized-login"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/tokenized-login.svg?style=flat-square" alt="Quality Score"></img></a>

With this package your can send a temporary token via laravel notifications (can be SMS, email, slack, ... ) to your users and they can login into their account with that 6 digit auto-expiring token.
Something like telegram login.

you have complete control on how things will happen and you are free to swap the default implementations with your own.

# Installation
```
composer require imanghafoori/laravel-tokenize-login
```
Then publish the config file:

```
php artisan vendor:publish
```



# Basic usage:
Basically, this package introduces 2 endpoints with which you can send requests to.

1. The first one is to generate and send the token to the user
```php
GET '/tokenized-login/request-token?email=iman@example.com'
```

2. The second one accepts the token and authoenticates the user if the token was valid.
```php
GET '/tokenized-login/login?email=iman@example.com'
```

Note: If you are not happy with the shape if the urls, you are free to cancel these out, and redefine them where ever you want.
you can take a look at the source code to find the controllers they refer to.

To disable the default routes you may set: ```'use_default_routes' => false,``` in the config file.

# Customization:
You can do a lot of customization and swap the default classes, with your own altenatives since we use the larave-smart-facade package.
Visit the config file to see what you can change.
