<?php

/**
 * Created by PhpStorm.
 * User: hp
 * Date: 11/01/2017
 * Time: 21:44
 */


namespace AppBundle\ServiceAvailability;


abstract class AbstractService
{
    use ExceptionHandler;

    protected static $state = array();
    /**
     * AbstractService constructor.
     */
    public function __construct()
    {
        set_error_handler(array($this,'exceptionHandler'));
    }

    public abstract function ping();

    public static function getState(){
        return static::$state;
    }
}
