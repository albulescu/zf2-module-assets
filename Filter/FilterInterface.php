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


namespace Assets\Filter;

interface FilterInterface {
	
	/**
	 * Filter asset content
	 * 
	 * @param string $value
	 */
	public function filter($value);
}