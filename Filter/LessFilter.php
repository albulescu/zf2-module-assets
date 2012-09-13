<?php

namespace Assets\Filter;

class LessFilter implements FilterInterface {
	
	/* (non-PHPdoc)
	 * @see \Assets\Filter\FilterInterface::filter()
	 */
	public function filter($value) {
		require_once __DIR__ . "/lib/less.php";
		$this->less = new \lessc();
		return $this->less->parse($value);
	}
}