<?php
namespace MBL\CSVRWBundle\Validator;

/**
 * Class UniversalDirectoryCSV
 * @package MBL\CSVRWBundle\Validator
 */
class UniversalDirectoryCSV
{

    /**
     * RegEx to validate each line
     */
    const LINE_REGEX = "/^(^0\d{9});(\d+(\.\d{1,2})?);(.{1,50})?$/";

    /**
     * RegEx to validate the header (first line)
     */
    const HEADER_REGEX = "/(.+);(.+);(.+)?$/";

    /**
     * CSV delimiter
     */
    const DELIMITER = ';';

    /**
     * Number of columns
     */
    const NUMBER_OF_COLUMNS = 3;

    /**
     * @param mixed $row
     *
     * @return boolean
     */
    public function parse($row)
    {
        if (preg_match(static::REGEX, implode(static::DELIMITER, $row))) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $header
     *
     * @return boolean
     */
    public function parseHead($header)
    {
        $return = false;

        if (count($header) === static::NUMBER_OF_COLUMNS && preg_match(
                self::HEADER_REGEX,
                implode(self::DELIMITER, $header)
            )
        ) {
            $return = true;
        }

        return $return;
    }
}