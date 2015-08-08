<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	$image_id = $_GET["id"];
	$size = @$_GET["size"];

	$image = new MagratheaImage($image_id);

	if(empty($image->filename))
		die("Invalid Image");

	$image->Load();

	

	if($size){
		if ($size == "thumb") {
			$image->Thumb();
		} else {
			$size = explode("x", $size);
			if(!empty($size[0]) && !empty($size[1])){
				$image->FixedSize($size[0], $size[1]);
			} else if (!empty($size[0])) {
				$image->FixedWidth($size[0]);
			} else if (!empty($size[1])) {
				$image->FixedHeight($size[0]);
			}
		}
	}

	echo $image->Code();


?>
