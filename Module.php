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

use Zend\Mvc\Router\Http\Wildcard;

use Zend\Mvc\Router\Http\Segment;

use Zend\Mvc\Router\Http\Literal;

use Zend\Mvc\Router\RouteStackInterface;

use Zend\Mvc\MvcEvent;

class Module {
	
	public function onBootstrap(MvcEvent $e) {
		
		$sm = $e->getApplication()->getServiceManager();
		
		$sm->setFactory("AssetsFilterManager",new AssetsFilterManagerFactory());
		$sm->setFactory("AssetsManager", new AssetsFactory());
	}

	public function getViewHelperConfig()
	{
		return array(
				'factories' => array(
						// the array key here is the name you will call the view helper by in your view scripts
						'asset' => function($sm){
							return new AssetLoaderHelper();
						},
				),
		);
	}
	
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__,
						),
				),
		);
	}
}