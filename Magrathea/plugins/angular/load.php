<?php

	$pluginFolder = "plugins/angular";

	MagratheaView::Instance()
		->IncludeJavascript($pluginFolder."/angular.min.js")
		->IncludeJavascript($pluginFolder."/angular-animate.min.js")
		->IncludeJavascript($pluginFolder."/angular-aria.min.js")
		->IncludeJavascript($pluginFolder."/angular-cookies.min.js")
		->IncludeJavascript($pluginFolder."/angular-csp.js")
		->IncludeJavascript($pluginFolder."/angular-loader.min.js")
		->IncludeJavascript($pluginFolder."/angular-messages.min.js")
		->IncludeJavascript($pluginFolder."/angular-mocks.js")
		->IncludeJavascript($pluginFolder."/angular-resource.min.js")
		->IncludeJavascript($pluginFolder."/angular-route.min.js")
		->IncludeJavascript($pluginFolder."/angular-sanitize.min.js")
		->IncludeJavascript($pluginFolder."/angular-scenario.js")
		->IncludeJavascript($pluginFolder."/angular-touch.min.js");


?>