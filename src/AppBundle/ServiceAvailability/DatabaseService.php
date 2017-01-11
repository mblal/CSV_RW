<?php
namespace AppBundle\ServiceAvailability;

use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DatabaseService extends AbstractService
{
    //use ExceptionHandler;
    protected $doctrine;

    /**
     * DatabaseService constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;

    }

    public function ping()
    {
        try {
            $this->doctrine->getConnection()->connect();
        } catch (\Exception $e) {
           trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

}