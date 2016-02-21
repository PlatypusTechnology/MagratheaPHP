<?php

	$pluginFolder = "plugins/dropzone";

	MagratheaView::Instance()
		->IncludeCss($pluginFolder."/dropzone.css")
		->IncludeJavascript($pluginFolder."/dropzone.js");

?>
