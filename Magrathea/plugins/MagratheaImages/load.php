<?php

	$pluginFolder = "plugins/MagratheaImages";

	include(__DIR__."/Model/MagratheaImage.php");

	$View->IncludeJavascript($pluginFolder."/config/javascript_vars.js");
	$View->IncludeJavascript($pluginFolder."/javascript/dropzone.js");

	$View->IncludeJavascript($pluginFolder."/javascript/magrathea_images.js");

	$View->IncludeJavascript($pluginFolder."/javascript/integration_colorbox.js");

	$View->IncludeCSS($pluginFolder."/css/magrathea_images.css");
	$View->IncludeCSS($pluginFolder."/css/dropzone.css");



?>