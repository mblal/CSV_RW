<?php

namespace MBL\CSVRWBundle\Reader;


use MBL\CSVRWBundle\Exception\RuntimeException;

/**
 * Class Csv
 * @package MBL\CSVRWBundle\Reader
 */
class Csv implements ReaderInterface
{

    const DELIMITER = ';';

    /**
     * Read a file and create an array
     *
     * @param $filename
     *
     * @return \SplFileObject
     */
    public function fromFile($filename)
    {
        if (!is_readable($filename) || !is_file($filename)) {
            throw new RuntimeException(sprintf(
                'File %s is not readable',
                $filename
            ));
        }

        try {
            $file = new \SplFileObject($filename);
            $file->setFlags(\SplFileObject::READ_CSV);
            $file->setCsvControl(static::DELIMITER);

            return $file;

        } catch (RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Read a string and create an array
     *
     * @param $string
     *
     * @return mixed
     */
    public function fromString($string)
    {
        // TODO: Implement fromString() method.
    }

}