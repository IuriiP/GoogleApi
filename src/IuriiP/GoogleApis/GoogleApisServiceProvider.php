<?php
namespace IuriiP\GoogleApi;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
class GoogleApiServiceProvider extends ServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        AliasLoader::getInstance()->alias('GoogleApi','IuriiP\GoogleApi\Facades\GoogleApiFacade');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['GoogleApi'] = $this->app->share(function($app)
        {
            $config = array();
            $config['applicationKey']   = Config::get('google-api.applicationKey');
            $config['requestUrl']       = Config::get('google-api.requestUrl');
            // Throw an error if request URL is empty
            if (empty($config['requestUrl'])) {
                throw new \InvalidArgumentException('Request URL is empty, please check your config file.');
            }
            return new GoogleApi($config);
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
