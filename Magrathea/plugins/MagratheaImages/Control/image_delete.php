<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	$id = $_GET["id"];

	$image = new MagratheaImage($id);
	$image->Delete();

?>
