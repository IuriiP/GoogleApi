# Google API
Google Maps API helper for Laravel 5.0

Read more on [Wiki](https://github.com/IuriiP/GoogleApi/wiki)

Installation
----

Update your `composer.json` file to include this package repository
```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/IuriiP/GoogleApi.git"
        }
    ]
```

Run composer
```bash
$ composer require iuriip/google-api
```


Register the service provider by adding it to the providers array in the `config/app.php` file.
```php
'providers' => array(
    'IuriiP\GoogleApi\GoogleApiServiceProvider',
)
```

Provide config
```bash
php artisan vendor:provide --config
```

Add your [Google application key](https://developers.google.com/maps/documentation/geocoding/get-api-key) 
into the created google-api.php
```php
'applicationKey' => 'yourKeyForTheGoogleApiAccess',
'requestUrl' => [
        'geocode' => 'https://maps.googleapis.com/maps/api/geocode/json?%s',
        'yourMethodName'=>'urlToJsonFormattedRequest',
],
```
