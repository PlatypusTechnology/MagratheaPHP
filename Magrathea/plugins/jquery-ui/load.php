<?php

	$pluginFolder = "plugins/jquery-ui";
	$theme = "flick";

	$View->IncludeJavascript($pluginFolder."/external/jquery/jquery.js");
	$View->IncludeJavascript($pluginFolder."/jquery-ui.min.js");

	$View->IncludeCSS($pluginFolder."/jquery-ui.min.css");
	$View->IncludeCSS($pluginFolder."/jquery-ui.structure.min.css");
	$View->IncludeCSS($pluginFolder."/jquery-ui.theme.min.css");

?>