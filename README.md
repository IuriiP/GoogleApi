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

Provide config
```bash
$ php artisan vendor:provide --config
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

Methods
----

- Predefined *static* helpers:
  - **string latlng(array $pair)** - format a coordinates pair as 'comma-separated' string
  - **string path(array $coords)** - format an array of coordinates as 'pipe-separated' string
  - **mixed getFirst(array $results[, array $types])** - get from results the first record with specified type (or just first)
  - **mixed getFirstPoint(array $results)** - call **getFirst** with the predefined 'point-oriented' list of types
  - **mixed getFirstLine(array $results)** - call **getFirst** with the predefined 'line-oriented' list of types ('route')
  - **mixed getFirstRoute(array $results)** - alias for **getFirstLine**
  - **mixed getFirstArea(array $results)** - call **getFirst** with the predefined 'area-oriented' list of types
  - **array useType(string|array $name)** - the $name parameter can be *array* , *comma-separated string* of names or just a predefined named type. 
  - **array useTypes(array $names)** - the $names parameter is array of the predefined named types. 

- Predefined named types:-
  - **point** any point
  - **station** any station
  - **address** any 'roof-top' address
  - **line** any line
  - **route** route
  - **area** any area
  - **administrative** any administrative area (1-5)
  - **locality** any locality
  - **sublocality** any sublocality (1-5)

All requests are 'pseudo-methods' and must has a specified key in the 'requestUrl' parameter.
The named parameters are expand with the key and insert as http-coded into the `%s` position.


