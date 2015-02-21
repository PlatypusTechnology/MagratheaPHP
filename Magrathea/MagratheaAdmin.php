<?php


/**
 * Class for handling and loading Magrathea's Admin system
 * More information on @link http://magrathea.platypusweb.com.br/admin_php.php
 * @todo  load plugins for font-awesome and jquery automatically from the function add plugin, instead adding the code on resources
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
	 */
	public function AddPlugin($pluginName){
		$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
		$inc = include($site_path."/plugins/".$pluginName."/load.php");
		if(!$inc)
			throw new MagratheaAdminException("Plugin [".$pluginName."] could not be found!");
			
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