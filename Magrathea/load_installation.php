<?php

$this_path = __DIR__;
$this_path = trim($this_path);
$this_path = explode("/", $this_path);
array_pop($this_path);
$site_path = implode("/", $this_path)."/";

require ($site_path."Magrathea/Exceptions.class.php");
require ($site_path."Magrathea/Functions.php");
require ($site_path."Magrathea/Database.class.php");
require ($site_path."Magrathea/Config.class.php");

$magdb = null;
try	{
	$environment = MagratheaConfigStatic::GetConfig("general/use_environment");
	$configSection = MagratheaConfigStatic::GetConfigSection($environment);
	$magdb = new Magdb();
	$magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
} catch (Exception $ex){
	$ready_to_install = false;
	$error_msg = "Error: ".$ex->getMessage();
}

date_default_timezone_set( MagratheaConfigStatic::GetConfig("general/time_zone") );


//include ("generated/models.magrathea.php");



?>