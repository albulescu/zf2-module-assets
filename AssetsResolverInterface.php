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

interface AssetsResolverInterface {
	
	
	/**
	 * Resolve request uri to a asset object
	 * 
	 * @param string $request Request Uri
	 * @return Assets\Asset\AssetInterface
	 */
	public function resolve( $request );
	
	
	/**
	 * Add new path to resolver
	 * 
	 * @param string $path Folder path
	 * @param string $namespace Namespace
	 */
	public function addPath( $path, $namespace = null);
}
