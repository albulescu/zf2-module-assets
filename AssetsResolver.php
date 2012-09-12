<?php

namespace Assets;

use Assets\Asset\CssAsset;

use Assets\Asset\JsAsset;

use Assets\Asset\GenericAsset;

class AssetsResolver implements AssetsResolverInterface {
	
	protected $paths = array();
	
	
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
		
		$this->paths[] = $path;
	}
	
	/**
	 * Resolve request to asset object
	 * @param request $path
	 * @return \Assets\Asset\AssetInterface
	 */
	public function resolve( $request ) {

		$file = null;
		
		foreach($this->paths as $path)
		{
			$dirIterator = new \DirectoryIterator($path);
			
			foreach($dirIterator as $item) {
				if(!$item->isDot() && $item->isDir()) {
					if(file_exists($item->getRealPath() . DIRECTORY_SEPARATOR . $request)) {
						$file = $item->getRealPath() . DIRECTORY_SEPARATOR . $request;
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
		
		$info = new \SplFileInfo($file);
		
		unset($finfo);
				
		switch( $mime )	
		{
			case "text/plain":
			case "text/x-php":
				
				switch($info->getExtension()) {
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