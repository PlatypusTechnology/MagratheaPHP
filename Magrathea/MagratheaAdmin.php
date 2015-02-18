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


}

?>