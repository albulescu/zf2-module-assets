<?php

namespace Assets\Filter;

use Assets\Filter\FilterInterface;

class PackerFilter implements FilterInterface {
	
	public function filter($value) {
		require_once __DIR__ . "/lib/jspacker.php";
		$myPacker = new \JavaScriptPacker($value, 62, true, false);
		return $myPacker->pack();
	}
}