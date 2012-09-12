Zend Framework 2 Assets module
==============================

Provide assets trought a route. All assets content is filtred and cached.
Text assets like .css and .js is rendered like a regular php with PhpRenderer.

Configuration
-------------

	'assets' => array(
		'paths'		=> array(
			APP_PATH . '/assets'
		),
		'filters' => array(
			'CssAsset'=>'CssCompressorFilter',
			'JsAsset'=>array(
				'JsMinFilter',
				'PackerFilter',
			)
		),
		'cache' => 'Cache'
	)

Rendered asset
--------------

	.box {
		width:100px;
	}
	
	<?php echo $this->render("other-cssfile"); ?>