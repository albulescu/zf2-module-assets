<?php

namespace Assets;

interface AssetsResolverInterface {
	
	public function resolve( $request );
	
	public function addPath( $path, $namespace = null);
}