<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 25/12/2016
 * Time: 01:10
 */

namespace AppBundle\Entity;

use MBL\CSVRWBundle\Annotation\Depndency;

class School
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $category;

    /**
     * @var Address
     * @Depndency(class="AppBundle\Entity\Address")
     */
    public $address;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }


}