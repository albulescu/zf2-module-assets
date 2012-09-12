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

namespace Assets\Asset;

use Zend\View\Resolver\TemplatePathStack;

use Zend\View\Renderer\PhpRenderer;

class RenderedAsset extends GenericAsset {
	
	/* (non-PHPdoc)
	 * @see \Assets\Asset\AssetInterface::getContent()
	*/
	public function getContent() {
	
		$info = new \SplFileInfo($this->file);
		
		$renderer = new PhpRenderer();
		
		$stack = new TemplatePathStack();
		$stack->addPath( $info->getPath() );
		$stack->setDefaultSuffix(pathinfo($this->file, PATHINFO_EXTENSION));
		$renderer->setResolver($stack);
		
		return $renderer->render( $info->getBasename() );
	}
}