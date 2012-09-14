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

use Assets\Asset\CssAsset;

use Assets\Asset\JsAsset;

use Assets\Asset\GenericAsset;

class AssetsResolver implements AssetsResolverInterface {

	protected $namespaces = array();
	
	public function __construct( $path = null ) {
		if($path)
		$this->addPath($path);
	}
	
	/**
	 * Add a new path for assets
	 * @param string $path
	 */
	public function addPath( $path, $namespace = null ) {
		if(!is_dir($path) && !is_readable($path)) {
			throw new \RuntimeException("Directory is not readable");
		}
		
		if(null === $namespace) {
			$namespace = "default";
		}
		
		$this->namespaces[$namespace] = $path;
	}
	
	/**
	 * Resolve request to asset object
	 * @param request $path
	 * @return \Assets\Asset\AssetInterface
	 */
	public function resolve( $request ) {

		$file = null;
		
		$request = '/' . ltrim($request,'/');
		
		foreach($this->namespaces as $namespace => $path)
		{
			if($namespace != 'default') {

				//if the namespace not found in this request do not resolve
				if(strpos($request, $namespace) != 1) {
					continue;
				}
				
				//remove the namspace from request
				$request = substr($request, strlen($namespace) + 1);
			}
			
			if(file_exists($path . $request)) {
				$file = $path . $request;
				break;
			}
			
			$dirIterator = new \DirectoryIterator($path);
			
			foreach($dirIterator as $item) {
				if(!$item->isDot() && $item->isDir()) {
					if(file_exists($item->getRealPath() . $request)) {
						$file = $item->getRealPath() . $request;
						break;
					}
				}
			}
		}
		
		if(is_dir($file)) {
			return null;
		}
		
		unset($dirIterator);
		
		if( ! $file ) {
			return null;
		}
		
		$finfo = new \finfo(FILEINFO_MIME_TYPE);
		
		$mime = $finfo->file($file);
		
		unset($finfo);
				
		$extension = strtolower(end(explode(".",$file)));
				
		switch( $mime )	
		{
			case "text/plain":
			case "text/x-php":
				
				switch( $extension ) {
					case "css":
						$asset = new CssAsset($file, "text/css");
						break;
						
					case "js":
						$asset = new JsAsset($file, "text/javascript");
						break;
				}
				
				break;
				
			default:
				$asset = new GenericAsset( $file, $mime );
				break;
		}

		return $asset;
	}
	
}