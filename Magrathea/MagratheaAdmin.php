<?php


class MagratheaAdmin { 

	public $title = "Magrathea Admin";
	public $args = array();

	public function Load(){
		$dir = __DIR__."/Magrathea_admin/";

		$page = @$_GET["page"];
		if(empty($page)) $page = "index.php";

		include ($dir.$page);
	}

	public function LoadCustom(){
		$dir = __DIR__."/Magrathea_admin/";

		$page = @$_GET["page"];
		if(empty($page)) $page = "index_custom.php";

		include ($dir.$page);
	}


}

?>