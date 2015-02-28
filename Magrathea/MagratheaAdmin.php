<?php


/**
 * Class for handling and loading Magrathea's Admin system
 * More information on @link http://magrathea.platypusweb.com.br/admin_php.php
 */
class MagratheaAdmin { 

	/**
	 * The title for your adming goes here
	 * @var string
	 */
	public $title = "Magrathea Admin";
	/**
	 * If you want to send any var inside the admin system, you can use an array of args through here!
	 * @var array
	 */
	public $args = array();

	/**
	 * constructor...
	 */
	public function MagratheaAdmin(){
		$dir = __DIR__."/Magrathea_admin/";
		$call = @$_GET["call"];
		if(!empty($call)){
			include($dir.$call.".php");
		}
		$this->LoadRequiredPlugins();
		$this->LoadOptPlugins();
	}

	/**
	 * Loading required plugins
	 * 	if those plugins are not there, nothing will work...
	 */
	private function LoadRequiredPlugins(){
		try{
			$this->AddPlugin("jquery1.7", true);
			$this->AddPlugin("bootstrap2", true);
		} catch (Exception $ex) {
			echo("Install missing plugins! => ".$ex->getMessage());
			die;
		}
	}

	/**
	 * Loading optional plugins
	 * 	if those plugins are not there, it will be ugly, but it will work...
	 */
	private function LoadOptPlugins(){
		try{
			$this->AddPlugin("font-awesome4");
			$this->AddPlugin("ibutton");
		} catch (Exception $ex) {
			echo("Install missing plugins! => ".$ex->getMessage());
		}
	}

	/**
	 * Loads the simple admin
	 */
	public function Load(){
		$dir = __DIR__."/Magrathea_admin/";
		$page = @$_GET["page"];
		if(empty($page)) $page = "index.php";

		include ($dir.$page);
	}

	/**
	 * Loads only the custom admin (available at Admin folder)
	 */
	public function LoadCustom(){
		$dir = __DIR__."/Magrathea_admin/";
		$page = @$_GET["page"];
		if(empty($page)) $page = "index_custom.php";

		include ($dir.$page);
	}

	/**
	 * Adds a plugin for admin
	 * @param 	string 		$pluginName 		folder of selected plugin
	 * @todo  load plugins for font-awesome and jquery automatically from the function add plugin, instead adding the code on resources
	 */
	public function AddPlugin($pluginName, $required=false){
		$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
		$inc = @include($site_path."/plugins/".$pluginName."/load.php");
		if(!$inc) {
			if($required) {
				echo "<br/><br/><a href='?call=plugin_install_req&plugin=".$pluginName."'>[Install ".$pluginName."]</a><br/><br/>";
			}
			throw new MagratheaAdminException("Plugin [".$pluginName."] could not be found!");
		}
			
	}

	/**
	 * adds CSS to the admin (it will be added inline in page)
	 * @param 	string 		$cssPath 		path of CSS (have to be in Admin folder)
	 */
	public function IncludeCSS($cssPath){
//		$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
		$admin_path = "../Admin";
		MagratheaView::Instance()->IncludeCSS($admin_path."/".$cssPath);
	}


}

?>