<?php

	$pluginFolder = "plugins/bootstrap4.1";

	MagratheaView::Instance()
		->IncludeCSS($pluginFolder."/css/bootstrap.min.css")
		->IncludeCSS($pluginFolder."/css/bootstrap-reboot.min.css")
		->IncludeCSS($pluginFolder."/css/bootstrap-grid.min.css")
//		->IncludeJavascript($pluginFolder."/js/bootstrap.min.js") // commented to avoid a conflict
		->IncludeJavascript($pluginFolder."/js/bootstrap.bundle.min.js");

?>
