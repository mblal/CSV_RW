<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 11/01/2017
 * Time: 21:09
 */

namespace AppBundle\ServiceAvailability;


trait ExceptionHandler
{
    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     */
    public function exceptionHandler($errno, $errstr, $errfile, $errline){
        static::$state[] = $errstr;
        //return 'blal';
    }
}