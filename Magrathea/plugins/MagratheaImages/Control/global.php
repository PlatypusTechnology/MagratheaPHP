<?php

	include(__DIR__."/../../../inc/global.php");
	$environment = MagratheaConfigStatic::GetEnvironment();
	$config = new MagratheaConfig();
	$config->setPath(__DIR__."/../config/");
	$config->setFile("MagratheaImages.conf");
	$security_file = $config->GetConfig($environment."/security_file");

	if( !empty($security_file) ){
		include(__DIR__."/../../../".$security_file);
	}

?>