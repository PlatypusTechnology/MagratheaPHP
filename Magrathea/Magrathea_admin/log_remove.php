<?php

require ("admin_load.php");

$file = $_GET["file"];

$logsPath = MagratheaConfig::Instance()->GetConfigFromDefault("site_path").'/../logs';
$filename = $logsPath."/".$file;

$output = shell_exec("rm ".$filename);
echo str_replace(PHP_EOL, '<br />', $output);  

?>