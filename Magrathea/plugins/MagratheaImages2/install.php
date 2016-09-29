<?php
// INSTALLER SCRIPT FOR PLUGINS

	function installMagratheaImages2() {

		$confFile = new MagratheaConfigFile();
		$confFile->setPath( realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs/") );
		$confFile->setFile( "magrathea_images.conf" );

		$configs = array(
			"images_path" => MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/images/medias",
			"generated_path" => MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/images/medias/_generated",
			"web_images_folder" => "http://".$_SERVER["HTTP_HOST"]."/images/medias",
			"web_images_generated" => "http://".$_SERVER["HTTP_HOST"]."/images/medias/_generated",
			"security_file" => "plugins/MagratheaImages2/magratheaImagesSecurity.php"
		);
		$defaultConfig = MagratheaConfig::Instance()->GetEnvironment();

		$confFile->setConfig( array( $defaultConfig => $configs ) );
		$confFile->createFileIfNotExists();
		$confFile->Save();

	}

	installMagratheaImages2();

?>
