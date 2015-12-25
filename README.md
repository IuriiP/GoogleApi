# GoogleApis
Google Maps APIs for Laravel 5.0

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


