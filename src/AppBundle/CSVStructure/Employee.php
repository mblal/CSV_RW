<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 25/12/2016
 * Time: 01:04
 */

namespace AppBundle\CSVStructure;


use MBL\CSVRWBundle\Formatter\AbstractCsvReader;

class Employee extends AbstractCsvReader
{
    /**
     * Get CSV Header
     * @return array
     */
    public function getHeader()
    {
        return array(
            'lastname' => 'lastname',
            'age' => 'age',
            'degree'=> 'degree',
            'job'=> 'job',
            'school_name'=> 'school.name',
            'school_category'=> 'school.category',
            'school_address' => 'school.address.zipCode',
            'firstname' => 'firstname'
        );
    }
}