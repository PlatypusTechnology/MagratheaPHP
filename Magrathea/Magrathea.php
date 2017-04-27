<?php

/**
 * Class for Magrathea details
 */
class Magrathea { 

	/**
	* 	Get Magrathea Version
	* @static
	* @return 	string 		Magrathea version
	*/
	public static function GetVersion() {
		$version_file = MagratheaConfig::Instance()->GetMagratheaPath()."/version";
		$version = file_get_contents($version_file);
		return $version;
	}

}

?>
