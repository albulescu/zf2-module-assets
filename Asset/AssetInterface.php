<?php
/**
 * WallSongs.net 
 *
 * All rights reserved 2012
 *
 * @author Albulescu Cosmin <cosmin@albulescu.ro>
 *
 */
 
 
namespace Assets\Asset;

interface AssetInterface {
	
	public function getContent();
	
	public function isModified($timestamp);
	
	public function getMime();
	
	public function getFile();
}