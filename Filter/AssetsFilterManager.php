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


namespace Assets\Filter;

use Zend\ServiceManager\ConfigInterface;

use Zend\ServiceManager\AbstractPluginManager;

use Zend\ServiceManager\ServiceManagerAwareInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class AssetsFilterManager extends AbstractPluginManager {
	
	const PLUGIN_MANAGER_CLASS = 'Assets\Filter\AssetsFilterManager';
	
	protected $filters = array(
        'CssCompressorFilter'=>'Assets\Filter\CssCompressorFilter',
		'JsMinFilter'=>'Assets\Filter\JsMinFilter',
		'PackerFilter'=>'Assets\Filter\PackerFilter'
    );
    
	public function __construct(ConfigInterface $config = null) {
		parent::__construct($config);
		
		foreach($this->filters as $filterName => $filterClass) {
			$this->setInvokableClass($filterName, $filterClass);
		}
	}
    
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractPluginManager::validatePlugin()
	 */
	public function validatePlugin($plugin) {
		if ($plugin instanceof FilterInterface) {
            // we're okay
            return;
        }

        throw new \RuntimeException(sprintf(
            'Filter of type %s is invalid; must implement %s\Filter\FilterInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));	
	}
}