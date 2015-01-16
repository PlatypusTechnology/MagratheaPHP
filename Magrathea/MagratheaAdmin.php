<?php


class MagratheaAdmin { 

	public function Load(){
		$dir = __DIR__."/../Magrathea_admin/";

		$page = @$_GET["page"];
		if(empty($page)) $page = "index.php";

		include ($dir.$page);
	}


}

?>