<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 11/01/2017
 * Time: 22:35
 */

namespace AppBundle\ServiceAvailability;


class HttpService extends AbstractService
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ping()
    {
        trigger_error('Errur de connextion au serveur HTTP', E_USER_ERROR);
    }
}