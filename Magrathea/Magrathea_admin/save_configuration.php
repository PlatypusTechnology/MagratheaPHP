<?php

require ("admin_load.php");
	
	$data = $_POST;
	if(@$data["use_environment"]){
		$path = MagratheaConfig::Instance()->GetConfig($data["use_environment"]."/site_path");
	} else {
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
	}

	$mconfig = new MagratheaConfigFile();
	$mconfig->setPath($path);
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
	try{
		$success = $mconfig->Save(true);
	} catch(Exception $ex) {
		MagratheaDebugger::Instance()->Error($ex);
		$error = $ex->getMessage();
		$success = false;
	}
	if( !$success ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... What the fuck happened?!</strong><br/>
			Could not create object config file. Please, be sure that PHP can write in the folder "Magrathea/configs/"...<br/>
			<?=(!empty($error) ? $error : "")?>
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

