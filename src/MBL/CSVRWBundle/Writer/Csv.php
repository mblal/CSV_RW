<?php

namespace MBL\CSVRWBundle\Writer;

use MBL\CSVRWBundle\Reader\Csv as CsvReader;

/**
 * Class Csv
 * 
 * @package MBL\CSVRWBundle\Writer
 */
class Csv extends AbstractWriter {
	
	/**
	 *
	 * @param
	 *        	$data
	 *        	
	 * @return mixed
	 */
	protected function processData(array $data) {
		$content = '';
		foreach ( $data as $row ) {
			$content .= implode ( CsvReader::DELIMITER, $row ) . PHP_EOL;
		}
		
		return $content;
	}
}