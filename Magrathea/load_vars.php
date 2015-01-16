<?php


if(isset($site_path)){
	MagratheaConfig::Instance()->setPath($site_path);
}

$magdb = null;
try	{
	$configSection = MagratheaConfig::Instance()->GetConfigSection(MagratheaConfig::Instance()->GetEnvironment());
	$magdb = Magdb::Instance();
	$magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
} catch (Exception $ex){
	$error_msg = "Error: ".$ex->getMessage();
	echo $error_msg; die;
}


// optional:
date_default_timezone_set( MagratheaConfig::Instance()->GetConfig("general/time_zone") );



?>