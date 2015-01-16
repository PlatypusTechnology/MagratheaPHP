<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	$id = $_GET["image_id"];

	$image = new MagratheaImage($id);
	echo $image->Load()->Thumb()->Code();


?>
