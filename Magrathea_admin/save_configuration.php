<?php

require ("admin_load.php");
	
	$data = $_POST;

	$mconfig = new MagratheaConfigFile();
	$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
	$mconfig->setFile("/../configs/magrathea.conf");
	$config = $mconfig->getConfig();

	if(empty($data["magrathea_use_environment"]))
		$config["general"] = $data;
	else {
		$environment = $data["magrathea_use_environment"];
		unset($data["magrathea_use_environment"]);
		$config[$environment] = $data;
	}


	$mconfig->setConfig($config);
	if( !$mconfig->Save(true) ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... What the fuck happened?!</strong><br/>
			Could not create object config file. Please, be sure that PHP can write in the folder "Magrathea/configs/"...
		</div>
		<?
		die;
	}

?>
<!--true--->
<div class="alert alert-success">
	<button class="close" data-dismiss="alert" type="button">×</button>
	<strong>Yeah, baby!</strong><br/>
	Configurations are saved! It works! It's alive! muahuhaua!! =P
</div>

