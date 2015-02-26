<?php

	$pluginFolder = "plugins/ColorBox";
	$theme = "theme_light";

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/javascript/jquery.colorbox-min.js")
		->IncludeCSS($pluginFolder."/".$theme."/colorbox.css");


?>