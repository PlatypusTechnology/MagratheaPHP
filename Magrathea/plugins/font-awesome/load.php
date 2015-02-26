<?php

	$pluginFolder = "plugins/Font-awesome";

	MagratheaView::Instance()
		->IncludeCSS($pluginFolder."/css/font-awesome.min.css")
		->IncludeCSS($pluginFolder."/css/font-awesome-ie7.min.css");

?>