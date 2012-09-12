<?php

namespace Assets\Filter;

class CssCompressorFilter implements FilterInterface {
	
	public function filter($value) {
		return str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$value)))));
	}
}