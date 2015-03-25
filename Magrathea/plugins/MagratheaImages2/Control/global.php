<?php

	include(__DIR__."/../../../inc/global.php");
	$config = new MagratheaConfigFile();
	$config->setPath(__DIR__."/../config/");
	$config->setFile("MagratheaImages.conf");
	$security_file = $config->GetConfig(MagratheaConfig::Instance()->GetEnvironment()."/security_file");

	if( !empty($security_file) ){
		include(__DIR__."/../../../".$security_file);
	}

?>