<?php

namespace Assets;

use Zend\Mvc\Router\Http\Wildcard;

use Zend\Mvc\Router\Http\Segment;

use Zend\Mvc\Router\Http\Literal;

use Zend\Mvc\Router\RouteStackInterface;

use Zend\Mvc\MvcEvent;

class Module {
	
	/**
	 * @var RouteStackInterface
	 */
	protected $router;
	
	public function onBootstrap(MvcEvent $e) {
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$this->router = $sm->get('Router');
		
		$sm->setFactory("AssetsManager", new AssetsFactory());

		$controllerLoader = $sm->get("ControllerLoader");
		$controllerLoader->setInvokableClass("AssetsController", "Assets\AssetsController");
		
		$route = new Segment("/assets[/:asset]",array('asset'=>'.*'), array(
			'controller'=>'AssetsController',
			'action'=>'index'		
		));
		
		$this->router->addRoute("assets", $route);
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