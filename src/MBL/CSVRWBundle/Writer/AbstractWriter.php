<?php

namespace MBL\CSVRWBundle\Writer;

use MBL\CSVRWBundle\Exception\InvalidArgumentException;

/**
 * Class AbstractWriter
 * @package Common\ToolsBundle\Service\Parser\Writer
 */
abstract class AbstractWriter implements WriterInterface
{
    /**
     * @param $filename
     * @param $data
     *
     * @throws \Exception
     */
    public function toFile($filename, $data)
    {
        if (empty($filename)) {
            throw new InvalidArgumentException('invalid filename');
        }

        try {
            file_put_contents($filename, $this->toString($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function toString($data)
    {
        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new InvalidArgumentException(
                sprintf('%s expects an array or Traversable data, %s given', __METHOD__, gettype($data))
            );
        }

        return $this->processData($data);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    abstract protected function processData(array $data);
}