TwitterOAuth Service Provider for Laravel 4
===============

A simple Laravel 4 service provider for including the [TwitterOAuth](https://github.com/tijsverkoyen/TwitterOAuth) library.

### Installation

The TwitterOAuth Service Provider can be installed via Composer by requiring the `"philo/laravel-twitter": "dev-master"` package in your project's composer.json.

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

`php artisan config:publish --path=philo/twitter philo/twitter`

You can setup your **CONSUMER_KEY** and **CONSUMER_SECRET** inside `app/config/packages/philo/twitter/config.php`.

```php
<?php

return array(
	'CONSUMER_KEY'    => '<your-app-key>',
	'CONSUMER_SECRET' => '<your-app-secret>'
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

### Usage

In order to access the API you need your user to authorize your application. To do so the user needs to be redirected to Twitter.

```php
// Visit http://site.com/twitter-redirect
Route::get('twitter-redirect', function(){
    // Reqest tokens
    $tokens = Twitter::oAuthRequestToken();

    // Redirect to twitter
    Twitter::oAuthAuthorize(array_get($tokens, 'oauth_token'));
    exit;
});
```

Once the user has authorized your app he/she is going to be redirect back to the callback URL you defined in your Twitter application settings.
You need to register that route and catch the verifier token:

```php
// Redirect back from Twitter to http://site.com/twitter-auth
Route::get('/twitter-auth', function(){
    // Oauth token
    $token = Input::get('oauth_token');

    // Verifier token
    $verifier = Input::get('oauth_verifier');

    // Request access token
    $accessToken = Twitter::oAuthAccessToken($token, $verifier);
});
```

Twitter will respond with the information that looks like:

```
array (size=4)
  'oauth_token' => string 'WFkvKyUG6K4-Vqntts8U4xQFzNHgNEAFTFMPxHH6fvQYwYsbuu' (length=50)
  'oauth_token_secret' => string 'RfVY4hwV7JeKe9WeQqpMUjLqZvKhZuhKp2wmN3MsKM' (length=43)
  'user_id' => string '123456789' (length=8)
  'screen_name' => string 'Philo01' (length=7)
```

You should store this information in order to access the authorized user in the future.
Please look at the source of `/vendor/tijsverkoyen/TijsVerkoyen/Twitter/Twitter.php` for all available methods.

***Example***
```php
try{
	$oAuth = User::find(1); // Get the tokens and twitter user_id you saved in the previous step

	// Setup OAuth token and secret
	Twitter::setOAuthToken($oAuth->oauth_token);
	Twitter::setOAuthTokenSecret($oAuth->oauth_token_secret);

	// Get tweets
	$timeline = Twitter::statusesUserTimeline($oAuth->user_id);

	// Display tweets
	dd($timeline);

}  catch(Exception $e) {
	// Error
	echo $e->getMessage();
}
```
