<?php
/**
 * GoogleApi
 *
 * @author Iurii Prudius <hardwork.mouse@gmail.com>
 */
namespace IuriiP\GoogleApi;

class GoogleApi {
    /*
      |--------------------------------------------------------------------------
      | Application Key
      |--------------------------------------------------------------------------
      |
      | Your application's API key. This key identifies your application for
      | purposes of quota management. Learn how to get a key from the APIs Console.
     */

    protected $applicationKey;

    /*
      |--------------------------------------------------------------------------
      | Request Urls
      |--------------------------------------------------------------------------
      |
     */
    protected $requestUrl;

    /**
     * Set Application Key and Request URL
     *
     */
    public function __construct($config) {
        $this->applicationKey = $config['applicationKey'];
        $this->requestUrl = $config['requestUrl'];
    }

    /**
     * Geocoding request
     *
     * @param array $param - request parameters
     *
     * @return array
     */
    public function geocode($param) {
        return $this->call('geocode', $param);
    }

    /**
     * Snap to road request
     *
     * @param array $param - request parameters
     *
     * @return array
     */
    public function road($param, $path = []) {
        if ($path) {
            $param['path'] = self::path($path);
            return $this->call('road', $param);
        }
        return [];
    }

    public function __call($name, $param) {
        return $this->call($name, $param);
    }

    public function __callStatic($name, $param) {
        $requestUrl = \Config::get('google-api.requestUrl');
        if (array_key_exists($request, $requestUrl)) {
            $param['key'] = \Config::get('google-api.applicationKey');
            $url = sprintf($requestUrl[$request], http_build_query($param));
            $answer = file_get_contents($url);
            $json = json_decode($answer, true);

            if ($json['status'] === 'OK') {
                return $json['results'];
            }
        }
        return [];
    }

    /**
     * 
     * @param string $request - request type
     * @param array $param - request parameters
     * @return array
     */
    public function call($request, $param) {
        if (array_key_exists($request, $this->requestUrl)) {
            $param['key'] = $this->applicationKey;
            $url = sprintf($this->requestUrl[$request], http_build_query($param));
            $answer = file_get_contents($url);
            $json = json_decode($answer, true);

            if ($json['status'] === 'OK') {
                return $json['results'];
            }
        }
        return [];
    }

    public static function latlng($pair) {
        return sprintf('%f,%f', $pair[0], $pair[1]);
    }

    public static function path($path) {
        return implode('|', array_map(self::latlng, $path));
    }

    public static function useTypes($names) {
        $keys = [];
        if (is_array($names)) {
            foreach ($names as $name) {
                $keys = array_merge($keys, self::useType($name));
            }
        }
        return array_unique($keys);
    }

    public static function useType($name) {
        if (is_string($name)) {
            switch (strtolower($name)) {
                case 'point':
                    return [ 'street_address', // indicates a precise street address.
                        'bus_station',
                        'train_station',
                        'transit_station', // indicate the location of a bus, train or public transit stop.
                        'establishment',
                        'premise', // indicates a named location, usually a building or collection of buildings with a common name
                        'subpremise', // indicates a first-order entity below a named location, usually a singular building within a collection of buildings with a common name
                        'natural_feature', // indicates a prominent natural feature.
                        'airport', // indicates an airport.
                        'park', // indicates a named park.
                        'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
                    ];
                case 'station':
                    return [ 'bus_station',
                        'train_station',
                        'transit_station', // indicate the location of a bus, train or public transit stop.
                    ];
                case 'address':
                    return [ 'street_address', // indicates a precise street address.
                        'establishment',
                        'premise', // indicates a named location, usually a building or collection of buildings with a common name
                        'subpremise', // indicates a first-order entity below a named location, usually a singular building within a collection of buildings with a common name
                        'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
                    ];
                case 'line':
                case 'route':
                    return ['route',
                        'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
                    ];
                case 'area':
                    return [
                        'administrative_area_level_1', // indicates a first-order civil entity below the country level. Within the United States, these administrative levels are states. Not all nations exhibit these administrative levels.
                        'administrative_area_level_2', // indicates a second-order civil entity below the country level. Within the United States, these administrative levels are counties. Not all nations exhibit these administrative levels.
                        'administrative_area_level_3', // indicates a third-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                        'administrative_area_level_4', // indicates a fourth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                        'administrative_area_level_5', // indicates a fifth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                        'colloquial_area', // indicates a commonly-used alternative name for the entity.
                        'locality', // indicates an incorporated city or town political entity.
                        'sublocality', // indicates a first-order civil entity below a locality. For some locations may receive one of the additional types: sublocality_level_1 to sublocality_level_5. Each sublocality level is a civil entity. Larger numbers indicate a smaller geographic area.
                        'sublocality_level_1',
                        'sublocality_level_2',
                        'sublocality_level_3',
                        'sublocality_level_4',
                        'sublocality_level_5',
                        'premise', // indicates a named location, usually a building or collection of buildings with a common name
                        'natural_feature', // indicates a prominent natural feature.
                        'park', // indicates a named park.
                        'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
                    ];
                case 'administrative':
                    return [
                        'administrative_area', // indicates a first-order civil entity below the country level. Within the United States, these administrative levels are states. Not all nations exhibit these administrative levels.
                        'administrative_area_level_1', // indicates a first-order civil entity below the country level. Within the United States, these administrative levels are states. Not all nations exhibit these administrative levels.
                        'administrative_area_level_2', // indicates a second-order civil entity below the country level. Within the United States, these administrative levels are counties. Not all nations exhibit these administrative levels.
                        'administrative_area_level_3', // indicates a third-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                        'administrative_area_level_4', // indicates a fourth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                        'administrative_area_level_5', // indicates a fifth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                    ];
                case 'locality':
                    return [
                        'colloquial_area', // indicates a commonly-used alternative name for the entity.
                        'locality', // indicates an incorporated city or town political entity.
                        'natural_feature', // indicates a prominent natural feature.
                        'park', // indicates a named park.
                        'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
                    ];
                case 'sublocality':
                    return [
                        'sublocality', // indicates a first-order civil entity below a locality. For some locations may receive one of the additional types: sublocality_level_1 to sublocality_level_5. Each sublocality level is a civil entity. Larger numbers indicate a smaller geographic area.
                        'sublocality_level_1',
                        'sublocality_level_2',
                        'sublocality_level_3',
                        'sublocality_level_4',
                        'sublocality_level_5',
                    ];
            }
            return self::useTypes(explode(',', $name));
        } elseif (is_array($name)) {
            return self::useTypes($name);
        }
        return [$name];
    }

    public static function isType($object, $type) {
        if (array_intersect($object['types'], self::useType($type))) {
            return true;
        }
        return false;
    }

    public static function hasType($object, $types=[]) {
        if(is_string($types)) {
            $types = (array) $types;
        }
        if ($found=array_intersect($object['types'], $types)) {
            return reset($found);
        }
        return null;
    }

    public static function isPoint($object) {
        if (array_intersect($object['types'], self::useType('point'))) {
            return true;
        }
        return false;
    }

    public static function getType($object) {
        return $object['types'][0];
    }

    public static function getPlaceId($object) {
        return $object['place_id'];
    }

    public static function getAddress($object,$format=null) {
        if($format) {
            $address = array_fill_keys($format, null);
            foreach ($object['address_components'] as $addr) {
                if ($type = \GoogleApi::hasType($addr, $format)) {
                    $address[$type] = $addr['short_name'];
                }
            }
            return implode(', ',$address);
        }
        return $object['formatted_address'];
    }

    public static function getShortName($object,$types=[]) {
        $address = self::getFirst($object['address_components'],$types);
        if ($address) {
            return $address['short_name'];
        }
        return $object['formatted_address'];
    }
    
    public static function getLongName($object,$types=[]) {
        $address = self::getFirst($object['address_components'],$types);
        if ($address) {
            return $address['long_name'];
        }
        return $object['formatted_address'];
    }
    
    public static function getCoords($object) {
        return [
            $object['geometry']['location']['lat'],
            $object['geometry']['location']['lng'],
        ];
    }

    public static function getBounds($object) {
        if (isset($object['geometry']['bounds'])) {
            return [
                $object['geometry']['bounds']['southwest']['lat'],
                $object['geometry']['bounds']['southwest']['lng'],
                $object['geometry']['bounds']['northeast']['lat'],
                $object['geometry']['bounds']['northeast']['lng'],
            ];
        }
        return [
            $object['geometry']['viewport']['southwest']['lat'],
            $object['geometry']['viewport']['southwest']['lng'],
            $object['geometry']['viewport']['northeast']['lat'],
            $object['geometry']['viewport']['northeast']['lng'],
        ];
    }

    public static function getFirst($objects, $types = []) {
        if ($types) {
            if ($objects) {
                foreach ($objects as $object) {
                    if (array_intersect($object['types'], $types)) {
                        return $object;
                    }
                }
            }
        } elseif ($objects) {
            return reset($objects);
        }
        return null;
    }

    public static function getFirstPoint($objects) {
        return self::getFirst($objects, self::useType('point'));
    }

    public static function getFirstLine($objects) {
        return self::getFirst($objects, self::useType('route'));
    }

    public static function getFirstRoute($objects) {
        return self::getFirstLine($objects);
    }

    public static function getFirstArea($objects) {
        return self::getFirst($objects, self::useType('area'));
    }

}
