<?php

namespace MBL\CSVRWBundle\Validator;

/**
 * Interface ValidatorInterface
 * @package MBL\CSVRWBundle\Validator;
 */
interface ValidatorInterface {

    /**
     * @param $value
     *
     * @return mixed
     */
    public function isValid($value);

    /**
     * @return mixed
     */
    public function getErrors();

}