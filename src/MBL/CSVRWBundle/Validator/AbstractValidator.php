<?php

namespace MBL\CSVRWBundle\Validator;

/**
 * Class AbstractValidator
 * @package MBL\CSVRWBundle\Validator
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}