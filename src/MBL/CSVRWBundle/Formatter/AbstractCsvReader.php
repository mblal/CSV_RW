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

    protected static $mainInstances, $instances=array();

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
        foreach ($content as $key => $row) {
            if ($key == 0) {
                continue;
            }
            ++$this->totalLines;

            $output[] = array_combine(array_values($this->getHeader()), $row);
        }

        return $output;
    }

    public function formatObject($content, $targetModel)
    {

        if (!$content instanceof \Traversable) {
            throw new RuntimeException(sprintf('Parameter must implement Traversable interface, %s given', gettype($content)));
        }

        $content = $this->formatBatch($content);

        $attributes = array();

        $annotationReader = new AnnotationReader();

        $current = 0;

        foreach ($content as $record) {
            $object = null;
            $this->main = true;
            static::$instances = array();
            static::$mainInstances[$current] = new $targetModel();

            foreach ($record as $attribute => $value) {

                $wEntity = new $targetModel;

                $attributes = explode($this->delimiter, $attribute);

                $i = 0;
                if (count($attributes) > 1) {

                    for ($i = 0; $i < count($attributes) - 1; $i++) {

                        $reflectionProp = new \ReflectionProperty($wEntity, $attributes[$i]);
                        $relation = $annotationReader->getPropertyAnnotation($reflectionProp, $this->annotationDefinition);
                        $instanceExists = array_key_exists($relation->class, static::$instances);
                        if ($object === null || !$instanceExists) {
                            $object = new $relation->class;
                            static::$instances[get_class($object)] = $object;
                        }
                        if ($instanceExists) {
                            $object = static::$instances[$relation->class];
                        }
                        $wEntity->$attributes[$i] = $object;

                        /*if ($this->main) {
                            static::$mainInstances[$current] = $wEntity;
                            $this->main = false;
                        }*/


                        $wEntity = $object;
                    }
                    $wEntity->{$attributes[$i]} = $value;
                    continue;
                }
                static::$mainInstances[$current]->{$attribute} = $value;
            }
            $current++;
        }
        return static::$mainInstances;
    }

    public function plan1($content, $targetModel)
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
                        //$lst[$key][$i][get_class($object)] = $object;
                        //$lst[$key][$attributes[$i]][get_class($object)] = $object;
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

    protected function rawHydrator(array $list){
        foreach ($list as $prentKey => $parent){
            foreach ($parent as $childKey => $child){
                if(is_object($child)){
                    $vars = get_object_vars($child);
                    foreach ($vars as $k => $v){
                        $child->$k = $parent[$k];
                    }
                }
            }
        }
        // TODO optimize $list structure with removing some data
       return $list;
    }
    protected function builRelation(array $list){
        foreach ($list as $prentKey => $parent){
            foreach ($parent as $childKey => $child){
                static::$mainInstances[$prentKey]->{$childKey} = $child;
                break;
            }
        }
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