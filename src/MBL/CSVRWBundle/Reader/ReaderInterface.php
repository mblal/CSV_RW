<?php

namespace MBL\CSVRWBundle\Reader;

/**
 * Interface ReaderInterface
 *
 * @package MBL\CSVRWBundle\Reader
 */
interface ReaderInterface {
	
	/**
	 * Read a file and create an array
	 *
	 * @param
	 *        	$filename
	 *        	
	 * @return mixed
	 */
	public function fromFile($filename);
	
	/**
	 * Read a string and create an array
	 *
	 * @param
	 *        	$string
	 *        	
	 * @return mixed
	 */
	public function fromString($string);
}