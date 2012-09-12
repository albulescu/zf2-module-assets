<?php 

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