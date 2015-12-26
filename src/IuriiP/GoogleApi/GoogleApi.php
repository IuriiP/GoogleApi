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

    public static function getFirst($objects, $types = []) {
        if ($types) {
            foreach ($objects as $object) {
                if (array_intersect($object['types'], $types)) {
                    return $object;
                }
            }
        }
        return null;
    }

    public static function getFirstPoint($objects) {
        return self::getFirst($objects, [
                    'street_address', // indicates a precise street address.
                    'bus_station',
                    'train_station',
                    'transit_station', // indicate the location of a bus, train or public transit stop.
                    'premise', // indicates a named location, usually a building or collection of buildings with a common name
                    'subpremise', // indicates a first-order entity below a named location, usually a singular building within a collection of buildings with a common name
                    'natural_feature', // indicates a prominent natural feature.
                    'airport', // indicates an airport.
                    'park', // indicates a named park.
                    'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
        ]);
    }

    public static function getFirstLine($objects) {
        return self::getFirst($objects, ['route',
                    'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
        ]);
    }

    public static function getFirstRoute($objects) {
        return self::getFirstLine($objects);
    }

    public static function getFirstArea($objects) {
        return self::getFirst($objects, [
                    'administrative_area_level_1', // indicates a first-order civil entity below the country level. Within the United States, these administrative levels are states. Not all nations exhibit these administrative levels.
                    'administrative_area_level_2', // indicates a second-order civil entity below the country level. Within the United States, these administrative levels are counties. Not all nations exhibit these administrative levels.
                    'administrative_area_level_3', // indicates a third-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                    'administrative_area_level_4', // indicates a fourth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                    'administrative_area_level_5', // indicates a fifth-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
                    'colloquial_area', // indicates a commonly-used alternative name for the entity.
                    'locality', // indicates an incorporated city or town political entity.
                    'sublocality', // indicates a first-order civil entity below a locality. For some locations may receive one of the additional types: sublocality_level_1 to sublocality_level_5. Each sublocality level is a civil entity. Larger numbers indicate a smaller geographic area.
                    'premise', // indicates a named location, usually a building or collection of buildings with a common name
                    'natural_feature', // indicates a prominent natural feature.
                    'park', // indicates a named park.
                    'point_of_interest', // indicates a named point of interest. Typically, these "POI"s are prominent local entities t
        ]);
    }

}
