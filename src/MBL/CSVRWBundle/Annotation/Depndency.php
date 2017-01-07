<?php
namespace MBL\CSVRWBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @author Mohamed BLAL
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Depndency extends Annotation
{

    public $class;

}