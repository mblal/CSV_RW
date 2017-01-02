<?php

namespace MBL\CSVRWBundle\Formatter;

/**
 * Interface FormatterInterface
 * @package MBL\CSVRWBundle\Formatter
 */
interface FormatterInterface {

    /**
     * Transform one line at the time
     * @param mixed $content
     *
     * @return mixed
     */
    public function format($content);

    /**
     * Transform all the content at once
     * @param $content
     *
     * @return mixed
     */
    public function formatBatch($content);
}