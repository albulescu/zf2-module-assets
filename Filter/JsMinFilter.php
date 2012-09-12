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

class JsMinFilter implements FilterInterface {
	
	/* (non-PHPdoc)
	 * @see \Assets\Filter\FilterInterface::filter()
	 */
	public function filter($value) {
		require_once __DIR__ . "/lib/jsmin.php";
		return \JSMin::minify($value);	
	}
}