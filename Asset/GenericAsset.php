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

use Assets\Asset\AssetInterface;

class GenericAsset implements AssetInterface {
	
	protected $file;
	
	protected $mime;
	
	public function __construct( $file, $mime ) {
		$this->file = $file;
		$this->mime = $mime;	
	}
	
	
	/* (non-PHPdoc)
	 * @see \Assets\Asset\AssetInterface::getContent()
	 */
	public function getContent() {
		return file_get_contents($this->file);
	}

	
	/* (non-PHPdoc)
	 * @see \Assets\Asset\AssetInterface::getMime()
	 */
	public function getMime()
	{
		return $this->mime;
	}
	
	
	/* (non-PHPdoc)
	 * @see \Assets\Asset\AssetInterface::getFile()
	 */
	public function getFile() {
		return $this->file;
	}
	
	
	/* (non-PHPdoc)
	 * @see \Assets\Asset\AssetInterface::isModified()
	 */
	public function isModified($timestamp) {
		$info = new \SplFileInfo($this->file);
		$mtime = $info->getMTime();
		unset($info);
		
		if( $mtime != $timestamp ) {
			return true;
		}
		
		return false;
	}
}
