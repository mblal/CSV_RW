<?php

namespace MBL\CSVRWBundle\Handler;


use MBL\CSVRWBundle\Reader\ReaderInterface;

/**
 * Interface ReaderHandlerInterface
 * @package MBL\CSVRWBundle\Handler
 */
interface ReaderHandlerInterface {

    /**
     * @param string $filename
     *
     * @return mixed
     */
    public function fromFile($filename);

    /**
     * @param MBL\CSVRWBundle\Reader\ReaderInterface $reader
     */
    public function setReader(ReaderInterface $reader);


    /**
     * @return MBL\CSVRWBundle\Reader\ReaderInterface
     */
    public function getReader();
}