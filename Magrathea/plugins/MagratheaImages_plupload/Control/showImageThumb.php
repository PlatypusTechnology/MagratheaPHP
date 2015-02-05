<?php

	include(__DIR__."/../../../inc/global.php");

	$id = $_GET["image_id"];

	$image = new MagratheaImage($id);
	echo $image->Load()->Thumb()->Code();


?>
