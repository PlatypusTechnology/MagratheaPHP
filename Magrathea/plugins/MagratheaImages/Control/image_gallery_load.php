<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	$page = $_GET["page"];

	$images = MagratheaImageControl::GetXMostRecent(12, $page);

	if(empty($images)){
		echo "That's all, folks!<br/></br>No more images at database... <br/> ";
	} else {
		$count = 0;
		foreach ($images as $image) {
//			p_r($image);
			$image->SilentLoad();
			if($count == 0 || $count%3 == 0){
				?>
				<div class="row-fluid">
				<?
			}
			$count ++;
			?>
			<div class="span4" id="magratheaImageTb_<?=$image->id?>">
				<a href="javascript:openImage('<?=$image->webImagesFolder.$image->filename?>');">
				<?=$image->Thumb()->Code()?>
				</a><br/>
				<div class="image_actions">
					<span class="image_name">[<?=$image->id?>] <?=$image->name?></span>
					<a href="javascript: magratheaDeleteImage(<?=$image->id?>);"><i class="icon-trash"></i></a>
				</div>
			</div>
			<?=($count%3 == 0 ? "</div><br/>" : "")?>
			<?
		}
		if($count%3 != 0) echo "</div>";
	}



?>