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

use Assets\Filter\FilterInterface;

class PackerFilter implements FilterInterface {
	
	/* (non-PHPdoc)
	 * @see \Assets\Filter\FilterInterface::filter()
	 */
	public function filter($value) {
		require_once __DIR__ . "/lib/jspacker.php";
		$myPacker = new \JavaScriptPacker($value, 62, true, false);
		return $myPacker->pack();
	}
}