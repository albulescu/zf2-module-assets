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

use Zend\Mvc\Router\Http\Segment;

use Zend\ServiceManager\ServiceManager;

use Zend\Stdlib\ArrayUtils;

use Assets\Filter\FilterInterface;

use Zend\Cache\Storage\Adapter\AbstractAdapter;

use Zend\Server\Cache;

use Zend\Http\Header\Connection;

use Zend\Http\Headers;

use Zend\Http\PhpEnvironment\Response;

class AssetsManager {
	
	/**
	 * The asset resolver class
	 * @var AssetsResolverInterface
	 */
	protected $resolver;
	
	
	/**
	 * Enter description here ...
	 * @var AbstractAdapter
	 */
	protected $cache;
	
	
	/**
	 * Keep the array with filters for each asset type
	 * @var array
	 */
	protected $filters = array();
		
	
	/**
	 * @var AssetsOptions
	 */
	protected $options;
	
	/**
	 * @var ServiceManager
	 */
	protected $serviceLocator;
	
	
	public function __construct( $options, $serviceLocator )
	{
		$this->serviceLocator = $serviceLocator;

		if($options) {
			$this->setOptions($options);
		}
	}
	
	/**
	 * @param AssetsOptions $options
	 * @throws \RuntimeException
	 */
	public function setOptions($options) {
		
		if(!($options instanceof AssetsOptions) && ! ArrayUtils::hasStringKeys($options)) {
			throw new \RuntimeException("Options must be an array with string keys");
		}
		if(is_array($options)) {
			$options = new AssetsOptions($options);
		}
		
		//Set the controller resolver
		$controllerLoader = $this->serviceLocator->get("ControllerLoader");
		$controllerLoader->setInvokableClass("AssetsController", "Assets\AssetsController");
		
		//Set the route
		$router = $this->serviceLocator->get('Router');
		$route = new Segment($options->getRoute(),array('asset'=>'.*'), array(
			'controller'=>'AssetsController',
			'action'=>'index'		
		));
		$router->addRoute("assets", $route);
		
		
		$filterManager = $this->serviceLocator->get('AssetsFilterManager');
		
		foreach( $options->getFilters() as $asset => $filters ) {
			foreach($filters as $filter) {
				
				if(!$filterManager->has($filter)) {
					throw new \RuntimeException("Filter $filter does not exist");
				}
				
				if(!isset($this->filters[$asset])) {
					$this->filters[$asset] = array();
				}
				
				$this->filters[$asset][] = $filterManager->get($filter); 
			}
		}
		foreach($options->getPaths() as $path) {
			$this->getResolver()->addPath($path);
		}
	}
	
	
	/**
	 * Set the asset resolver
	 * @param AssetsResolverInterface $resolver
	 * @throws RuntimeException
	 */
	public function setResolver($resolver) {
		
		if(!$resolver instanceof AssetsResolverInterface) {
			throw new \RuntimeException("The resolver must implement the AssetsResolverInterface");
		}
		
		$this->resolver = $resolver;
	}
	
	
	/**
	 * Enter description here ...
	 * @return AssetsResolverInterface
	 */
	public function getResolver() {
		if(!$this->resolver) {
			$this->resolver = new AssetsResolver();
		}
		
		return $this->resolver;
	}
	
	
	/**
	 * @param string $request Request uri
	 * @throws \RuntimeException
	 * @return \Zend\Http\PhpEnvironment\Response
	 */
	public function dispatch( $request ) {

		if(!$this->getResolver()) {
			throw new \RuntimeException("No resolver setted");
		}
		
		$asset = $this->resolver->resolve( $request );

		$content = null;
		$responseCode = 404;
		$headers = Headers::fromString("Content-Type: text/plain");
		
		if($asset)
		{
			$headers = $this->getHeaders($asset->getFile(), $asset->getMime());
			
			if( $this->browserCached($asset->getFile()) ) {
				$responseCode = 304;
				$headers->addHeader( Connection::fromString("Connection: close") );
			}
			else
			{
				$responseCode = 200;
				
				$cacheKey = "assets-cache-" . md5($request);
				
				if( $this->cache ) {
					$content = $this->cache->getItem($cacheKey);
				}
				
				if( ! $content ) {
					
					$content = $asset->getContent();
					$assetName = end(explode('\\',get_class($asset)));
					
					if(array_key_exists($assetName, $this->filters))
					{
						foreach( $this->filters[$assetName] as $filter )
						{
							$content = $filter->filter($content);
						}
					}
					
					if($this->cache) {
						$this->cache->addItem($cacheKey, $content);
					}
				}
			}
		}
		else {
			$content = "Asset not found!";
		}
		
		$response = new Response();
		
		$response->setStatusCode( $responseCode );
		$response->setContent( $content );
		$response->setHeaders( $headers );
		
		return $response;
	}
	
	
	/**
	 * Add fiter
	 * @param string $forAssetClass
	 * @param FilterInterface $filter
	 */
	public function addFilter($forAssetClass, $filter ) {
		
		if(!$filter instanceof FilterInterface) {
			throw new RuntimeException("Filter must be an instance of FilterInterface");
		}
		
		if(!isset($this->filters[$forAssetClass])) {
			$this->filters[$forAssetClass] = array();
		}
		
		$this->filters[$forAssetClass][] = $filter;
	}
	
	
	/**
	 * @param  $cache
	 */
	public function setCache($cache) {
		//TODO: Cache
	}
	
	
	/**
	 * Test if file is cached
	 * 
	 * @param string $file
	 * @return boolean
	 */
	protected function browserCached( $file ) {

		
		$info = new \SplFileInfo($file);
		
		$filetime = $info->getMTime();
		
		unset($info);
		
		$last_modified = date('D, d M Y H:i:s', $filetime) . ' GMT';
		
		$PageWasUpdated = !(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and
				strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $filetime);
			
		$DoIDsMatch = (isset($_SERVER['HTTP_IF_NONE_MATCH']) and
				@ereg(md5($last_modified), $_SERVER['HTTP_IF_NONE_MATCH']));
			
		if (!$PageWasUpdated || $DoIDsMatch)
		{
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * Get headers for caching file and type
	 * 
	 * @param string $mime File mimetype
	 * @return \Zend\Http\Headers
	 */
	protected function getHeaders($file, $mime ) {
		
		$cache_days = 20;
		
		$info = new \SplFileInfo($file);
		
		$filetime = $info->getMTime();
		
		unset($info);

		$last_modified = date('D, d M Y H:i:s', $filetime) . ' GMT';
		$expires       = date('D, d M Y H:i:s', strtotime('+30 days',$filetime)) . ' GMT';
		$hasid         = md5($last_modified);

		$headers = "Cache-Control: max-age=".($cache_days * 24 * 60 * 60) . "\r\n" .
		"Pragma: private\r\n" .
		"Last-Modified: ".$last_modified . "\r\n" .
		"Expires: ".$expires . "\r\n" .
		"Vary: Accept-Encoding\r\n" .
		"Etag: ".$hasid . "\r\n" .
		"Content-Type: " . $mime . "\r\n";

		return Headers::fromString($headers);
	}
}
