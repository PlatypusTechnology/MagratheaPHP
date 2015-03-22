<?php

	$pluginFolder = "plugins/MagratheaImages2";

	include(__DIR__."/Model/MagratheaImage.php");

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/config/javascript_vars.js")
		->IncludeJavascript($pluginFolder."/javascript/MagratheaImages.js")

		->IncludeCSS($pluginFolder."/css/magrathea_images.css")
		->IncludeCSS($pluginFolder."/css/dropzone.css");



?>