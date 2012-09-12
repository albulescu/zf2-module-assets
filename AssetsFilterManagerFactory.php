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

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class AssetsFilterManagerFactory extends AbstractPluginManagerFactory {
	const PLUGIN_MANAGER_CLASS = 'Assets\Filter\AssetsFilterManager';
}