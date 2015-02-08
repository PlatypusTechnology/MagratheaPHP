<?php

	include(__DIR__."/../../../inc/global.php");

	$images = MagratheaImageControl::GetAll();
//	p_r($images);

	$Smarty->assign("images", $images);
	$Smarty->display("plugins/MagratheaImages/gallery_select.html");


?>