# GoogleApis
Google Maps APIs helper for Laravel 5.0

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
  - ```php 
string function latlng(array $pair)
``` - format a coordinates pair as 'comma-separated' string
  - **string path(array $coords)** - format an array of coordinates as 'pipe-separated' string
  - **mixed getFirst(array $results[, array $types])** - get from results the first record with specified type (or just first)
  - **mixed getFirstPoint(array $results)** - call **getFirst** with the predefined 'point-oriented' list of types
  - **mixed getFirstLine(array $results)** - call **getFirst** with the predefined 'line-oriented' list of types ('route')
  - **mixed getFirstRoute(array $results)** - alias for the **getFirstLine**
  - **mixed getFirstArea(array $results)** - call **getFirst** with the predefined 'area-oriented' list of types
  - **array useType(string|array $name)** - returns the list of types. The `$name` parameter can be *array* , *comma-separated string* of names or just a predefined named type. 
  - **array useTypes(array $names)** - returns the list of types. The `$names` parameter is array of the predefined named types. 
  - **boolean isType(mixed $object,$type)** - check if `$object` is a type `$type`. 
  - **boolean isPoint(mixed $object)** - check if `$object` is a 'point'. 
  - **string hasType(mixed $object,$types)** - get the first intersected type of `$object`. 
  - **string getType(mixed $object)** - get the best type of `$object`. 
  - **string getPlaceId(mixed $object)** - get the 'place_id' of `$object`. 
  - **array getCoords(mixed $object)** - get the `[lat,lng]` coordinates of `$object`. 
  - **array getBounds(mixed $object)** - get the `[minlat,minlng,maxlat,maxlng]` coordinates of `$object`. 
  - **string getAddress(mixed $object[,array $format])** - get the formatted address of `$object`. 
The `$format` array contains list of used types of 'address_components' in same order as need. Returns
'formatted_address' if `$format` is omitted.
  - **array getShortName(mixed $object[,array $types])** - get the 'short_name' of first specified type
in 'address_components'. 
  - **array getLongName(mixed $object[,array $types])** - get the 'long_name' of first specified type
in 'address_components'. 

- Predefined named types:-
  - **point** - any point
  - **station** - any station
  - **address** - any 'roof-top' address
  - **line** - any line
  - **route** - route
  - **area** - any area
  - **administrative** - any administrative area (1-5)
  - **locality** - any locality
  - **sublocality** - any sublocality (1-5)

All requests are *pseudo-methods* and must has a specified key in the `requestUrl` parameter.
The named parameters are expand with the `key=yourKeyForTheGoogleApiAccess` 
and insert as http-coded string into the `%s` position in the `requestUrl` string .


