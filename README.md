TwitterOAuth Service Provider for Laravel 4
===============

A simple Laravel 4 service provider for including the TwitterOAuth library written by [Tijs Verkoyen](https://github.com/tijsverkoyen/TwitterOAuth).

### Installation

The TwitterOAuth Service Provider can be installed via Composer by requiring the `"philo/laravel-twitter": "dev-master"` package and setting the minimum-stability to dev (required for Laravel 4) in your project's composer.json.

```php
{
    "require": {
        "laravel/framework": "4.0.*",
        "philo/laravel-twitter": "dev-master"
    },
    "minimum-stability": "dev"
}
```

Next you will need to publish the package config:

`php artisan config:publish philo/twitter`

You can setup your **CONSUMER_KEY** and **CONSUMER_SECRET** inside `app/config/packages/philo/twitter/config.php`.

```php
<?php

return array(
  'CONSUMER_KEY'    => '',
	'CONSUMER_SECRET' => ''
);
```

Finaly you need to register the service provider and the alias. Look for `providers` inside app/config/app.php register it.

```php
'providers' => array(
	// ...
	'Philo\Twitter\TwitterServiceProvider',
)
```

And do the same for the alias:

```php
'aliases' => array(
	// ...
	'Twitter' => 'Philo\Twitter\Facades\Twitter',
)
```
