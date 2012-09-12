Zend Framework 2 Assets module
==============================

Provide assets trought a route. All assets content is filtred and cached.
Text assets like .css and .js is rendered like a regular php with PhpRenderer.

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
	'cache' => 'Cache'
)