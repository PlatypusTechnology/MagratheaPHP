<?php

	include(__DIR__."/global.php");
	include(__DIR__."/../load.php");

	echo $View->CSSs();
	echo $View->Javascripts();

?>

<form action="/plugins/MagratheaImages/Control/upload_image.php" class="dropzone">
	<div class="fallback">
	<input name="file" type="file" multiple />
	</div>
</form>

