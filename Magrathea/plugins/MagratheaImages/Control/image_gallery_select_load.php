<?

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	$page = $_GET["page"];

	$images = MagratheaImageControl::GetXMostRecent(12, $page);

//	p_r($images);

	if(empty($images)){
		echo "That's all, folks!<br/></br>No more images at database... ";
	} else {
		$count = 0;
		foreach ($images as $image) {
			$image->SilentLoad();
			if($count == 0 || $count%3 == 0){
				?>
				<div class="row-fluid">
				<?
			}
			$count ++;
			?>
			<div class="span4" id="magratheaImageTb_<?=$image->id?>">
				<a href="javascript:selectImage('<?=$image->id?>');">
				<?=$image->Thumb()->Code()?>
				</a><br/>
				<div class="image_actions">
					<span class="image_name"><?=$image->name?></span>
				</div>
			</div>
			<?=($count%3 == 0 ? "</div><br/>" : "")?>
			<?
		}
		if($count%3 != 0) echo "</div>";
	}

?>