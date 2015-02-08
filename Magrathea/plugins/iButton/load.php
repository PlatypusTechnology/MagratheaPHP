<?php

	$pluginFolder = "plugins/iButton";

	$View->IncludeJavascript($pluginFolder."/javascript/jquery.ibutton.min.js");
	$View->IncludeJavascript($pluginFolder."/javascript/jquery-ui-1.8.20.custom.min.js");
	// OPTIONAL: only if easing is not defined yet...
//	$View->IncludeJavascript($pluginFolder."/javascript/jquery.easing.1.3.js");

	$View->IncludeCSS($pluginFolder."/css/jquery.ibutton.min.css");

?>