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
    public function call($request,$param) {
        if(array_key_exists($request, $this->requestUrl)) {
            $param['key'] = $this->applicationKey;
            $url = sprintf($this->requestUrl[$request],http_build_query($param));
            $answer = file_get_contents($url);
            $json = json_decode($answer, true);

            if ($json['status'] === 'OK') {
                return $json['results'];
            }
        }
        return [];
    }
    
    public static function latlng($pair) {
        return sprintf('%f,%f',$pair[0],$pair[1]);
    }

    public static function path($path) {
        return implode('|',array_map(self::latlng,$path));
    }

}
