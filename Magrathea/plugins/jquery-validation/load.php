<?php

	$pluginFolder = "plugins/jquery-validation";

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/jquery.validate.min.js")
		->IncludeJavascript($pluginFolder."/additional-methods.min.js");


?>