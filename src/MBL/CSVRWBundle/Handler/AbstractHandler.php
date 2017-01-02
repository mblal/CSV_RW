<?php

namespace MBL\CSVRWBundle\Handler;

use MBL\CSVRWBundle\Formatter\FormatterInterface;
use MBL\CSVRWBundle\Reader\ReaderInterface;
use MBL\CSVRWBundle\Writer\WriterInterface;

/**
 * Class AbstractHandler
 * @package MBL\CSVRWBundle\Handler
 */
abstract class AbstractHandler implements ReaderHandlerInterface, WriterHandlerInterface
{

    /**
     * @var MBL\CSVRWBundle\Formatter\FormatterInterface
     */
    protected $formatter = null;

    /**
     * @var MBL\CSVRWBundle\Reader\ReaderInterface
     */
    protected $reader = null;

    /**
     * @var MBL\CSVRWBundle\Writer\WriterInterface
     */
    protected $writer = null;

    /**
     * @return MBL\CSVRWBundle\Formatter\FormatterInterface
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param MBL\CSVRWBundle\Formatter\FormatterInterface $formatter
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param MBL\CSVRWBundle\Reader\ReaderInterface $reader
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return WriterInterface
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * 
     * {@inheritDoc}
     * @see MBL\CSVRWBundle\Handler\WriterHandlerInterface::setWriter()
     */
    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;
    }
}