<?php namespace IuriiP\GoogleApi\Facades;

/**
 * Description of Client
 *
 * @author Iurii Prudius
 */
use Illuminate\Support\Facades\Facade;

class GoogleApiFacade extends Facade {

    protected static function getFacadeAccessor() {

        return "GoogleApi";
    }

}
