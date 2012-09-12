<?php

namespace Assets;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class AssetsFilterManagerFactory extends AbstractPluginManagerFactory {
	const PLUGIN_MANAGER_CLASS = 'Assets\Filter\AssetsFilterManager';
}