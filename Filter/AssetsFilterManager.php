<?php

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