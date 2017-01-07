<?php

namespace MBL\CSVRWBundle\Formatter;

use AppBundle\Entity\School;
use Doctrine\Common\Annotations\AnnotationReader;
use MBL\CSVRWBundle\Exception\RuntimeException;

/**
 * Class AbstractCsvReader
 * @package MBL\CSVRWBundle\Formatter
 */
abstract class AbstractCsvReader implements FormatterInterface
{

    protected static $mainInstances, $instances = array();

    protected $annotationDefinition = 'MBL\CSVRWBundle\Annotation\\Depndency';

    protected $main = true;

    protected $delimiter = '.';

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

        if (!$content instanceof \Traversable) {
            throw new RuntimeException(
                sprintf(
                    'Parameter must implement Traversable interface, %s given',
                    gettype($content)
                )
            );
        }

        $output = array();
        $csvFileHeader = array();
        foreach ($content as $key => $row) {
            if ($key == 0) {
                $csvFileHeader = $row;
                continue;
            }
            ++$this->totalLines;
            $output[] = array_combine(array_values($this->sortHeader($csvFileHeader)), $row);
        }

        return $output;
    }

    /**
     * @param $content
     * @param $targetModel
     * @return mixed
     */
    public function getObjectModel($content, $targetModel)
    {
        $attributes = array();
        $annotationReader = new AnnotationReader();

        if (!$content instanceof \Traversable) {
            throw new RuntimeException(sprintf('Parameter must implement Traversable interface, %s given', gettype($content)));
        }

        $content = $this->formatBatch($content);
        foreach ($content as $key => $record) {

            static::$mainInstances[$key] = new $targetModel();

            foreach ($record as $attribute => $value) {

                $wEntity = new $targetModel;

                $attributes = explode($this->delimiter, $attribute);

                if (count($attributes) > 1) {

                    for ($i = 0; $i < count($attributes) - 1; $i++) {

                        $reflectionProp = new \ReflectionProperty($wEntity, $attributes[$i]);
                        $relation = $annotationReader->getPropertyAnnotation($reflectionProp, $this->annotationDefinition);
                        $object = new $relation->class;
                        $lst[$key][$attributes[$i]] = $object;
                        $wEntity = $object;
                    }
                    $lst[$key][$attributes[$i]] = $value;
                    continue;
                }
                static::$mainInstances[$key]->{$attribute} = $value;

            }
        }
        $lst = $this->rawHydrator($lst);
        $this->builRelation($lst);
        return static::$mainInstances;
    }

    /**
     * @param array $list
     * @return array
     */
    protected function rawHydrator($list = array())
    {
        foreach ($list as $prentKey => $parent) {
            foreach ($parent as $childKey => $child) {
                if (is_object($child)) {
                    $vars = get_object_vars($child);
                    foreach ($vars as $k => $v) {
                        $child->$k = $parent[$k];
                    }
                }
            }
        }
        // TODO optimize $list structure with removing some data
        return $list;
    }

    /**
     * @param array $list
     */
    protected function builRelation($list = array())
    {
        foreach ($list as $prentKey => $parent) {
            foreach ($parent as $childKey => $child) {
                static::$mainInstances[$prentKey]->{$childKey} = $child;
                break;
            }
        }
    }

    /**
     * @param $fileHeader
     * @return array
     */
    protected function sortHeader($fileHeader = array())
    {
        $sortStrategy = $this->getHeader();
        $output = array();
        foreach ($fileHeader as $item) {
            $output[$item] = $this->getHeader()[$item];
        }
        return $output;
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