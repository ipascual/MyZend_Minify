<?php
namespace Minify\View\Helper;

use Minify;
use Zend\View\Helper\AbstractHelper;

class MinifyFiles extends AbstractHelper
{
	public function __invoke($file) {
		$publicFolder = "/var/www/htdocs/leaseapp.com/public";
		$minifyName = "min-";
		
		$filesToMinify = array();
		$minifyFolder = $publicFolder;
		$hashName = "";
		
		// files to minify		
		if(strpos($file, "*") !== false) {
			// minify folder target
			$pathData = pathinfo($file);
			$minifyFolder = $minifyFolder.$pathData["dirname"];
			$baseUrl = $pathData["dirname"];
			$minifyExt = $pathData["extension"];
			
			// get files to minify
			$d = dir($publicFolder.$pathData["dirname"]);
			while (false !== ($entry = $d->read())) {
				if(($entry != ".") && ($entry != "..") && (strpos($entry, ".") !== 0) && (strpos($entry, "min") !== 0)) {
					$filesToMinify[] = $publicFolder.$pathData["dirname"]."/".$entry;
					$hashName .=  $entry." ";
				}
			}
			$d->close();
		}
		else {
			$filesToMinify[] = $publicFolder.$file;

			// minify folder target
			$pathData = pathinfo($file);
			$baseUrl = $pathData["dirname"];
			$minifyFolder = $minifyFolder.$pathData["dirname"];
			$minifyExt = $pathData["extension"];
			$hashName .=  $file." ";
		}

		// find minify file
		$minifyName = $minifyName.hash("md5", $hashName);
		$finalMinifyName = "";
		foreach(glob($minifyFolder."/".$minifyName."*") as $localFile) {
			$finalMinifyName = basename($localFile);
		}
		
		// create minified file
		if(! $finalMinifyName) {
			$finalMinifyName = $minifyName."-".uniqid().".".$minifyExt;
			file_put_contents($minifyFolder."/".$finalMinifyName, Minify::combine($filesToMinify));
		}
		
		return $baseUrl."/".$finalMinifyName;
	}

}
