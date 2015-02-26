<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

?>
<div id="image_gallery">

</div>
<div class="image_gallery_load_more center" >
	<input type="hidden" id="image_pageNumber" value="0" />
	<button class="btn btn-default" id="image_loadButton" onClick="magratheaLoadImages();">Load!</button>
</div>