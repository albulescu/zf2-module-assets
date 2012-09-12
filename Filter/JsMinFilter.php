<?php

namespace Assets\Filter;

class JsMinFilter implements FilterInterface {
	
	public function filter($value) {
		require_once __DIR__ . "/lib/jsmin.php";
		return \JSMin::minify($value);	
	}
}