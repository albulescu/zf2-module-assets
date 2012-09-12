<?php

namespace Assets;

use Zend\Stdlib\AbstractOptions;

class AssetsOptions extends AbstractOptions {
	
	protected $paths;
	
	protected $filters;
	
	
	public function getPaths() {
		return $this->paths;
	}
	
	public function setPaths($paths) {
		$this->paths = array_map(function($e){ return rtrim($e,"/"); }, $paths);
	}
	
	
	public function getFilters() {
		return $this->filters;
	}
	
	public function setFilters($filters) {
		
		if(!is_array($filters)) {
			throw new RuntimeException("Filters must be an array");
		}
		
		foreach( $filters as $asset => $assetsFilters ) {
			
			if(is_string($assetsFilters)) {
				$assetsFilters = array($assetsFilters);
			}
			
			$this->filters[$asset] = $assetsFilters;
		}
	}
	
	public function setCache() {
		
	}
}