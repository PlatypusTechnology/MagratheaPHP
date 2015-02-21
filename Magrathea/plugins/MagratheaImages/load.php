<?php

	$pluginFolder = "plugins/MagratheaImages";

	include(__DIR__."/Model/MagratheaImage.php");

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/config/javascript_vars.js")
		->IncludeJavascript($pluginFolder."/javascript/dropzone.js")
		->IncludeJavascript($pluginFolder."/javascript/magrathea_images.js")
		->IncludeJavascript($pluginFolder."/javascript/integration_colorbox.js")

		->IncludeCSS($pluginFolder."/css/magrathea_images.css")
		->IncludeCSS($pluginFolder."/css/dropzone.css");



?>