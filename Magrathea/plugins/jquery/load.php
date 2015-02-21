<?php

	$pluginFolder = "plugins/jquery";

	MagratheaView::Instance()
		->IncludeCSS($pluginFolder."/css/bootstrap-theme.min.css")
		->IncludeCSS($pluginFolder."/css/bootstrap.min.css")
		->IncludeJavascript($pluginFolder."/js/bootstrap.min.js");


?>