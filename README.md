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

Rendered asset ( css or js )
----------------------------
	<?php $size = 100; ?>
	
	.box {
		width:<?php echo $size; ?>px;
	}
	
	.style {
		height:200px;
	}
	
	<?php echo $this->render("other-cssfile"); ?>
	
Accessing the assets
--------------------
	Folder path
	/assets/css/style.css
	/assets/css/other/box.css
	/assets/js/main.js
	/assets/js/jquery/plugin.js
	/assets/images/pic.jpg
	
	Url
	/assets/style.css
	/assets/other/box.css
	/assets/main.js
	/assets/jquery/plugin.js
	/assets/pic.jpg