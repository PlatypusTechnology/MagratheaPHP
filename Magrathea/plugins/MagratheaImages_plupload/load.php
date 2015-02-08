<?php

	$pluginFolder = "plugins/MagratheaImages_plupload";

	include(__DIR__."/Model/MagratheaImage.php");

	$View->IncludeJavascript($pluginFolder."/javascript/plupload.js");
	$View->IncludeJavascript($pluginFolder."/javascript/plupload.html4.js");
	$View->IncludeJavascript($pluginFolder."/javascript/plupload.html5.js");
	$View->IncludeJavascript($pluginFolder."/javascript/jquery.plupload.queue.js");
	$View->IncludeJavascript($pluginFolder."/javascript/magrathea_uploader.js");

	$View->IncludeJavascript($pluginFolder."/javascript/integration_colorbox.js");

	$View->IncludeCSS($pluginFolder."/css/jquery.plupload.queue.css");
	$View->IncludeCSS($pluginFolder."/css/jquery.ui.plupload.css");
	$View->IncludeCSS($pluginFolder."/css/magrathea_images.css");



?>