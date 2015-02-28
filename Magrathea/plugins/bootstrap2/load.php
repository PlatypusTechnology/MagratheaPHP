<?php

	$pluginFolder = "plugins/bootstrap2";

	MagratheaView::Instance()
		->IncludeCSS($pluginFolder."/css/bootstrap.min.css")
		->IncludeCSS($pluginFolder."/css/bootstrap-responsive.min.css")
		->IncludeJavascript($pluginFolder."/js/bootstrap.min.js");


?>