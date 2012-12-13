<?php

namespace Assets;

use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author cosmin
 *        
 */
class AssetLoaderHelper extends AbstractHelper {
	// TODO - Insert your code here
	
	public function __invoke( $asset ) {
		return "/assets/$asset";
	}
}

?>