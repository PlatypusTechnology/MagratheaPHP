<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");


$image = new MagratheaImage();
$image->LoadConfig();

// Settings
$targetDir = $image->imagesPath;

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);


// upload file:
	$file = $_FILES["file"];
	$imageName = $file["name"];

	$imageNameArr = explode(".", $imageName);

	$image->extension = array_pop($imageNameArr);
	$image->name = implode(" ", $imageNameArr);
	$image->SetFilename($imageName);
	$image->size = $file["size"];
	$image->file_type = $file["type"];

	$finalName = $targetDir."/".$image->filename;
	move_uploaded_file($_FILES["file"]["tmp_name"], $finalName);
	chmod($finalName, 0777);

	$imageId = 0;
	if(file_exists($finalName)){
		$imageId = $image->Insert();
	}

	if(!empty($imageId)){
		echo "true";
	} else {
		echo "false";
	}

?>