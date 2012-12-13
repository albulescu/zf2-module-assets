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


namespace Assets;

use Zend\Stdlib\AbstractOptions;

class AssetsOptions extends AbstractOptions {
	
	/**
	 * Keep the list of assets paths
	 * 
	 * @var array
	 */
	protected $paths;
	
	
	/**
	 * Keep the list of filters
	 * 
	 * @var array
	 */
	protected $filters;
	
	
	/**
	 * @var The route options
	 */
	protected $route;
	
	/**
	 * Set the route for rendering assets
	 * @param array $route
	 */
	public function setRoute($route) {
		$this->route = $route;
	}
	
	/**
	 * Get route for rendering assets
	 */
	public function getRoute() {
		return $this->route;
	}
	
	/**
	 * Get the list of added paths
	 * 
	 * @return array
	 */
	public function getPaths() {
		return $this->paths;
	}
	
	
	/**
	 * Set the resolver paths
	 * @param array $paths
	 */
	public function setPaths($paths) {
		$this->paths = array_map(function($e){ return rtrim($e,"/"); }, $paths);
	}
	
	
	/**
	 * Get the filters added
	 * 
	 * @return multitype:Assets\Filter\FilterInterface
	 */
	public function getFilters() {
		return $this->filters;
	}
	
	
	/**
	 * Set filters 
	 * @param array $filters
	 * @throws RuntimeException
	 */
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
		//TODO: cache
	}
}