<?php

	$pluginFolder = "plugins/MagratheaImages2";

	include(__DIR__."/Model/MagratheaImage.php");

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/javascript/MagratheaImages.js");


?>