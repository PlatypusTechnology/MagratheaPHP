<?php

	include(__DIR__."/../../../inc/global.php");
	$confFile = new MagratheaConfigFile();
	$confFile->setPath( realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs/") );
	$confFile->setFile( "magrathea_images.conf" );
	$security_file = $confFile->GetConfig(MagratheaConfig::Instance()->GetEnvironment()."/security_file");

	if( !empty($security_file) ){
		include(__DIR__."/../../../".$security_file);
	}

?>