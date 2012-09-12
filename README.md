ZF2 Assets module
=================

Provide assets trought a route. All assets content data is filtred by your given filters
You can use an asset like a regular php, because is rendered with PhpRenderer.

Configuration
_____________

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
		'cache' => 'Cache' // from service manager
), 