<?php

namespace MBL\CSVRWBundle\Validator;

use MBL\CSVRWBundle\Exception\RuntimeException;

/**
 * Class CsvValidator
 * @package MBL\CSVRWBundle\Validator
 */
class CsvValidator extends AbstractValidator
{
    protected $delimiter = ";";
    /**
     *
     * @var array
     */
    protected $skipLines = array();

    /**
     * RegEx for header validation
     *
     * @var string
     */
    protected $headerRegExValidation = null;

    /**
     * RegEx line validation
     *
     * @var string
     */
    protected $lineRegExpValidation = null;

    /**
     * Stop at the first error if $breakIfError is true
     *
     * @var bool
     */
    protected $breakIfError = false;
    const ERR_MSG_HEADER = 'Bad header format';
    const ERR_MSG_LINE = 'Line format %d is wrong';

    /**
     *
     * @param
     *            $content
     *
     * @return bool
     */
    public function isValid($content)
    {
        if (!$content instanceof \Traversable) {
            throw new RuntimeException (sprintf('Parameter must implement Traversable interface, %s given', gettype($content)));
        }

        $isValid = true;

        foreach ($content as $key => $row) {
            $position = $key + 1;

            if (count($this->skipLines) && in_array($position, $this->skipLines)) {
                continue;
            }

            if ($position == 1) {
                if (!empty ($this->headerRegExValidation) && !preg_match($this->headerRegExValidation, implode($this->delimiter, $row))) {
                    $this->errors [] = static::ERR_MSG_HEADER;
                    $isValid = false;
                }
            } else {
                if (!empty ($this->lineRegExpValidation) && !preg_match($this->lineRegExpValidation, implode($this->delimiter, $row))) {
                    $this->errors [] = sprintf(static::ERR_MSG_LINE, $key);
                    $isValid = false;
                }
            }

            if ($this->breakIfError) {
                return $isValid;
            }
        }

        return $isValid;
    }

    /**
     *
     * @return string
     */
    public function getHeaderRegExValidation()
    {
        return $this->headerRegExValidation;
    }

    /**
     *
     * @param string $headerRegExValidation
     */
    public function setHeaderRegExValidation($headerRegExValidation)
    {
        $this->headerRegExValidation = $headerRegExValidation;
    }

    /**
     *
     * @return string
     */
    public function getLineRegExpValidation()
    {
        return $this->lineRegExpValidation;
    }

    /**
     *
     * @param string $lineRegExpValidation
     */
    public function setLineRegExpValidation($lineRegExpValidation)
    {
        $this->lineRegExpValidation = $lineRegExpValidation;
    }

    /**
     *
     * @return array
     */
    public function getSkipLines()
    {
        return $this->skipLines;
    }

    /**
     *
     * @param array $skipLines
     */
    public function setSkipLines(array $skipLines)
    {
        $this->skipLines = $skipLines;
    }

    /**
     *
     * @return boolean
     */
    public function isBreakIfError()
    {
        return $this->breakIfError;
    }

    /**
     *
     * @param boolean $breakIfError
     */
    public function setBreakIfError($breakIfError)
    {
        $this->breakIfError = $breakIfError;
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}