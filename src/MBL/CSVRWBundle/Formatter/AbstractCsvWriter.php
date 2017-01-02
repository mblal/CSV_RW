<?php

namespace MBL\CSVRWBundle\Formatter;

use MBL\CSVRWBundle\Exception\RuntimeException;

/**
 * Class CsvWriter
 * @package MBL\CSVRWBundle\Formatter
 */
abstract class AbstractCsvWriter implements FormatterInterface
{
    /**
     * @var int
     */
    protected $totalLines = 0;

    /**
     * Transform one line at the time
     *
     * @param mixed $content
     *
     * @return mixed
     */
    public function format($content)
    {
        return $content;
    }

    /**
     * Transform all the content at once
     *
     * @param Traversable $content
     *
     * @return array
     */
    public function formatBatch($content)
    {
    	$output = array();
        if (!is_array($content) && !$content instanceof \Traversable) {
            throw new RuntimeException(
                sprintf(
                    'Parameter must implement Traversable interface, %s given',
                    gettype($content)
                )
            );
        }

        $header = array_keys($this->getHeader());
        //$fields = array_values($this->getHeader());
        $this->totalLines = 0;

        foreach ($content as $row) {
            $output[] = $this->processData($row);
            ++$this->totalLines;
        }

        // Add CSV Header to the output
        array_unshift($output, $header);
        return $output;
    }

    /**
     * Format data using header attributes
     *
     * @param $row
     *
     * @return array
     */
    protected function processData($row){
        $data = array();
        $header = $this->getHeader();

        foreach($header as $key => $field){
            if(null === $field){
                continue;
            }
            $count = 0;
            $callback = preg_replace('/callback_/', '', $field, -1, $count);

            // If the attribute is a callback function
            if($count > 0){
                if(method_exists($this, $callback)) {
                    $data[$key] = $this->{$callback}($row);
                }
                else{
                    throw new RuntimeException(sprintf('Undefined method : %s in %s', $callback, get_called_class()));
                }
                continue;
            }
            // If the attribute is a nested array
            $fields = explode('.', $field);
            $value = array();
            foreach($fields as $f){
                $value = !count($value) ? $row[$f] : $value[$f];
            }

            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Get total lines
     * @return int
     */
    public function getTotalLines()
    {
        return $this->totalLines;
    }

    /**
     * Get CSV Header
     * @return array
     */
    abstract public function getHeader();
}