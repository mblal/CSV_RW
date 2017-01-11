<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 11/01/2017
 * Time: 22:37
 */

namespace AppBundle\ServiceAvailability;


use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceDirectory
{
    //protected $container;

    /*
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    */
    public function getServices(){
        return array(
            'database_service',
            'http_service'
        );
    }
}