<?php


if(isset($site_path)){
	MagratheaConfig::Instance()->setPath($site_path);
}

$magdb = null;
try	{
	loadMagratheaEnv();
} catch (Exception $ex){
	$error_msg = "Error: ".$ex->getMessage();
	echo $error_msg; die;
}

// optional:
date_default_timezone_set( MagratheaConfig::Instance()->GetConfig("general/time_zone") );



?>