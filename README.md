

# Two factor authentication in Laravel

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
2. The second one accepts the token and authoenticates the user if the token was valid.

# Customization:
You can do a lot of customization and swap the default classes, with your own altenatives since we use the larave-smart-facade package.
Visit the config file to see what you can change.
