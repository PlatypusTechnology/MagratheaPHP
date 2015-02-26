<?php

	$pluginFolder = "plugins/jquery-ui";
	$theme = "flick";

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/external/jquery/jquery.js")
		->IncludeJavascript($pluginFolder."/jquery-ui.min.js")
		->IncludeCSS($pluginFolder."/jquery-ui.min.css")
		->IncludeCSS($pluginFolder."/jquery-ui.structure.min.css")
		->IncludeCSS($pluginFolder."/jquery-ui.theme.min.css");

?>