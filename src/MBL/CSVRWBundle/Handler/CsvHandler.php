<?php

namespace MBL\CSVRWBundle\Handler;


/**
 * Class CsvHandler
 * @package MBL\CSVRWBundle\Handler
 */
class CsvHandler extends AbstractHandler
{

    /**
     * @param string $filename
     *
     * @return mixed
     */
    public function fromFile($filename){
        $content = $this->reader->fromFile($filename);

        if($this->formatter instanceof FormatterInterface){
            $content = $this->formatter->formatBatch($content);
        }

        return $content;
    }

    /**
     * @param string $filename
     * @param $data
     *
     * @return mixed
     */
    public function toFile($filename, $data)
    {
        $content = $this->writer->toFile($filename, $data);

        if($this->formatter instanceof FormatterInterface){
            $content = $this->formatter->formatBatch($content);
        }

        return $content;
    }

}