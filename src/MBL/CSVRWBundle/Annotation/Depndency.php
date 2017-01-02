<?php
namespace MBL\CSVRWBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Depndency extends Annotation
{

    public $class;

}