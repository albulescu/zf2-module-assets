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

use Zend\Http\Headers;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\ServiceManager\ServiceManager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

class AssetsController extends AbstractActionController implements ServiceLocatorAwareInterface {
	
	/**
	 * @var ServiceManager
	 */
	protected $serviceLocator;
	
	
	public function indexAction() {
		
		$requestUri = $this->getEvent()->getRouteMatch()->getParam('asset');
		
		$response = $this->serviceLocator->get('AssetsManager')->dispatch( $requestUri );
		
		$this->getEvent()->setResponse($response);
		
		return $response;
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}

	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
}