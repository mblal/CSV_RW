<?php

namespace MBL\CSVRWBundle\Handler;


use MBL\CSVRWBundle\Writer\WriterInterface;

/**
 * Interface WriterHandlerInterface
 * @package Common\ToolsBundle\Service\Parser\Handler
 */
interface WriterHandlerInterface {

    /**
     * @param string $filename
     *
     * @return mixed
     */
    public function toFile($filename, $data);

    /**
     * @param MBL\CSVRWBundle\Writer\WriterInterface $writer
     */
    public function setWriter(WriterInterface $writer);

    /**
     * @return MBL\CSVRWBundle\Writer\WriterInterface
     */
    public function getWriter();
}