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
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$router = $sm->get('Router');
		
		$sm->setFactory("AssetsManager", new AssetsFactory());

		$controllerLoader = $sm->get("ControllerLoader");
		$controllerLoader->setInvokableClass("AssetsController", "Assets\AssetsController");
		
		$route = new Segment("/assets[/:asset]",array('asset'=>'.*'), array(
			'controller'=>'AssetsController',
			'action'=>'index'		
		));
		
		$router->addRoute("assets", $route);
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