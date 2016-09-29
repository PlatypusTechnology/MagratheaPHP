<?php

	include(__DIR__."/../../../inc/global.php");
	$config = new MagratheaConfigFile();
	$config->setPath( realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs/") );
	$config->setFile("magrathea_images.conf");
	$security_file = $config->GetConfig(MagratheaConfig::Instance()->GetEnvironment()."/security_file");

	if( !empty($security_file) ){
		include(__DIR__."/../../../".$security_file);
	}

?>