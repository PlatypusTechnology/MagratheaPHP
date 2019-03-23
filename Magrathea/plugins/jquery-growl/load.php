<?php

	$pluginFolder = "plugins/jquery-growl";

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/javascript/jquery.growl.js")
		->IncludeCSS($pluginFolder."/css/jquery.growl.css");

?>
