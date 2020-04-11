<?php

/**
* 
* Plugins function - update 2020
*	great for work alongside dockerized applications
**/
class MagratheaPlugins {

	private $magrathea_path;
	private $site_path;
	private $plugin;

	public $verbose = false;

	public function __construct(){
		$this->magrathea_path = MagratheaConfig::Instance()->GetMagratheaPath()."/plugins/";
		$this->site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/plugins/";
	}

	private function v($data) {
		if($this->verbose) {
			echo $data."<br/>\n";
		}
	}

	private function rrmdir($dir) {
		if (is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file)
				if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
			rmdir($dir);
		}
		else if (file_exists($dir)) unlink($dir);
	}

	private function rcopy($src, $dst) {
		$this->v("copying [".$src."] =====> [".$dst."]");
		if (file_exists($dst)) $this->rrmdir($dst);
		if (is_dir($src)) {
			mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file)
				if ($file != "." && $file != "..") $this->rcopy("$src/$file", "$dst/$file");
		}
		else if (file_exists($src)) copy($src, $dst);
	}

	/**
	 * Install plugin
	 */
	public function Install($pluginName) {
		$this->plugin = $pluginName;
		$this->v("installing ".$pluginName."...");
		$this->rcopy(
			$this->magrathea_path.$pluginName,
			$this->site_path.$pluginName
		);
		$this->v("<hr/>");
	}
}

?>