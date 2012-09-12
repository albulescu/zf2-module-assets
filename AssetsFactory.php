<?php

namespace Assets;

use Zend\ServiceManager\FactoryInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

class AssetsFactory implements FactoryInterface {
	
	public function createService(ServiceLocatorInterface $serviceLocator) {

		$configuration	= $serviceLocator->get('ApplicationConfig');
		
		$serviceLocator->setFactory("AssetsFilterManager", new AssetsFilterManagerFactory());
		
		$options		= new AssetsOptions( $configuration['assets'] );
		$manager		= new AssetsManager($options, $serviceLocator);
		
		return $manager;
	}
}