<?php

namespace MBL\CSVRWBundle\Writer;

/**
 * Interface WriterInterface
 * 
 * @package MBL\CSVRWBundle\Writer
 */
interface WriterInterface {
	
	/**
	 *
	 * @param
	 *        	$filename
	 * @param
	 *        	$data
	 */
	public function toFile($filename, $data);
	
	/**
	 *
	 * @param $data
	 *        	
	 * @return string
	 */
	public function toString($data);
}