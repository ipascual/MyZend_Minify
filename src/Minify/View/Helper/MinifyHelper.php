<?php
namespace Minify\View\Helper;

use Minify;
use Zend\View\Helper\AbstractHelper;

class MinifyHelper extends AbstractHelper
{
	public function getRealPublicPath() {
		return getcwd()."/public";
	}
	
	public function getFilePrefix() {
		return "min-";
	}
	
	public function __invoke($file) {
		// files to minify		
		$filesToMinify = $this->getFiles($file);

		// hash
		$hash = $this->getHash($filesToMinify);

		// get path of minified file
		$pathMinify = $this->findRealPathMinify($filesToMinify);

		// find minify file
		$finalMinifyName = $this->fileExists($pathMinify."/".$this->getFilePrefix().$hash."*");
		
		// create minified file
		if(! $finalMinifyName) {
			$finalMinifyName = $this->getFilePrefix().$hash."-".uniqid().".".$this->getFilesExtension($filesToMinify);
			file_put_contents($pathMinify."/".$finalMinifyName, Minify::combine($filesToMinify));
		}

		return $this->findWebPathMinify($file)."/".$finalMinifyName;
	}
	
	public function findRealPathMinify($files) {
		$file = $files;
		if(is_array($files)) {
			$file = reset($files);
		}
		return dirname($file);
	}

	public function findWebPathMinify($files) {
		$file = $files;
		if(is_array($files)) {
			$file = reset($files);
		}
		return dirname($file);
	}
	
	public function fileExists($file) {
		
		$finalMinifyName = false;
		if(glob($file)) {
			foreach(glob($file) as $localFile) {
				$finalMinifyName = basename($localFile);
			}
		}
		return $finalMinifyName;
	}
	
	public function getFilesExtension($files) {
		$ext = "";
		
		foreach($files as $file) {
			$pathData = pathinfo($file);
			$ext = $pathData["extension"];
		}
		
		return $ext;
	}
	
	public function getFiles($files) {
		$filesToMinify = array();

		if(is_array($files)) {
			foreach($files as $file) {
				$filesToMinify = array_merge($filesToMinify, $this->getFilesFromString($file));	
			}	
		}
		else {
			$filesToMinify = array_merge($filesToMinify, $this->getFilesFromString($file));	
		}
		
		return array_unique($filesToMinify);
	}
	
	public function getFilesFromString($file) {
		$filesToMinify = array();
		
		// wildcard conditions
		if(strpos($file, "*") !== false) {
			// minify folder target
			$pathData = pathinfo($file);
			
			// list files
			$d = dir($this->getRealPublicPath().$pathData["dirname"]);
			while (false !== ($entry = $d->read())) {
				if(($entry != ".") && ($entry != "..") && (strpos($entry, ".") !== 0) && (strpos($entry, "min") !== 0)) {
					$filesToMinify[] = $this->getRealPublicPath().$pathData["dirname"]."/".$entry;
				}
			}
			$d->close();
		}
		else {
			$filesToMinify[] = $this->getRealPublicPath().$file;
		}
		
		return $filesToMinify;
	}
	
	
	public function getHash($files) {
		$hashName = "";
		foreach($files as $file) {
			$hashName .=  $file." ";
		}

		return hash("md5", $hashName); 
	}

}
