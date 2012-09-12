<?php
/**
 *
 * Albulescu Cosmin ( http://www.albulescu.com/ )
 *
 * @link      http://www.albulescu.com/
 * @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
 * @license   http://www.albulescu.ro/new-bsd New BSD License
 * @autor Albulescu Cosmin <cosmin@albulescu.ro>
 *
 */

namespace Assets\Asset;

interface AssetInterface {
	
	/**
	 * Get the file content
	 */
	public function getContent();
	
	
	/**
	 * Check if the file is modified
	 * @param string $timestamp
	 */
	public function isModified($timestamp);
	
	
	/**
	 * Get modified time
	 * @return string
	 */
	public function getMime();
	
	
	/**
	 * Get the file path
	 * 
	 * @return string
	 */
	public function getFile();
}
