<?php

namespace MBL\CSVRWBundle\Factory;

use MBL\CSVRWBundle\Formatter\FormatterInterface;
use MBL\CSVRWBundle\Exception\RuntimeException;
use MBL\CSVRWBundle\Writer\WriterInterface;

/**
 * Class Factory
 * @package MBL\CSVRWBundle\Factory
 */
class Factory
{

    /**
     * @var array
     */
    protected static $readers = array(
        'csv' => 'MBL\CSVRWBundle\Reader\Csv',
    );

    /**
     * @var array
     */
    protected static $writers = array(
        'csv' => 'MBL\CSVRWBundle\Writer\Csv',
    );

    /**
     * @var array
     */
    protected static $handlers = array(
        'csv' => 'MBL\CSVRWBundle\Handler\CsvHandler',
    );

    /**
     * @param $filename
     * @param MBL\CSVRWBundle\Formatter\FormatterInterface $formatter
     *
     * @return mixed
     */
    public static function fromFile($filename, FormatterInterface $formatter = null)
    {
        $pathinfo = pathinfo($filename);

        if (!isset($pathinfo['extension'])) {
            throw new RuntimeException(
                sprintf(
                    'Extension is missing for the filename "%s"',
                    $filename
                )
            );
        }

        $extension = strtolower($pathinfo['extension']);
        // temporary statement | TODO FIX IT
        if ($extension === 'tmp'){
            $extension = 'csv';
        }
        if (!isset(static::$readers[$extension])) {
            throw new RuntimeException(
                sprintf(
                    'Unsupported extension : .%s',
                    $extension
                )
            );
        }

        $reader = static::$readers[$extension];
        $readerHandler = static::$handlers[$extension];

        if (!$reader instanceof ReaderInterface) {
            $reader = new static::$readers[$extension];
            static::$readers[$extension] = $reader;
        }

        if (!$readerHandler instanceof ReaderHandlerInterface) {
            $readerHandler = new static::$handlers[$extension];
            static::$handlers[$extension] = $readerHandler;
        }

        if ($formatter instanceof FormatterInterface) {
            $readerHandler->setFormatter($formatter);
        }

        $readerHandler->setReader($reader);

        return $readerHandler->fromFile($filename);
    }

    public static function toFile($filename, $data, FormatterInterface $formatter = null)
    {
        $pathinfo = pathinfo($filename);

        if (!isset($pathinfo['extension'])) {
            throw new RuntimeException(
                sprintf(
                    'Extension is missing for the filename "%s"',
                    $filename
                )
            );
        }

        $extension = strtolower($pathinfo['extension']);

        if (!isset(static::$readers[$extension])) {
            throw new RuntimeException(
                sprintf(
                    'Unsupported extension : .%s',
                    $extension
                )
            );
        }

        $writer = static::$writers[$extension];
        $writerHandler = static::$handlers[$extension];

        if (!$writer instanceof WriterInterface) {
            $writer = new static::$writers[$extension];
            static::$readers[$extension] = $writer;
        }

        if (!$writerHandler instanceof WriterHandlerInterface) {
            $writerHandler = new static::$handlers[$extension];
            static::$handlers[$extension] = $writerHandler;
        }

        if ($formatter instanceof FormatterInterface) {
            $writerHandler->setFormatter($formatter);
        }

        $writerHandler->setWriter($writer);

        return $writerHandler->toFile($filename, $data);
    }
}