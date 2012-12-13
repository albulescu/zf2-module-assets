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

use Zend\ServiceManager\FactoryInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

class AssetsFactory implements FactoryInterface {
	
	public function createService(ServiceLocatorInterface $serviceLocator) {

		$configuration	= $serviceLocator->get('Config');
		
		$options		= new AssetsOptions( $configuration['assets'] );
		$manager		= new AssetsManager($options, $serviceLocator);
		
		return $manager;
	}
}