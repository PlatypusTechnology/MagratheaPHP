<?php

require ("admin_load.php");

$file = $_GET["file"];
$lines = $_GET["lines"];

$logsPath = MagratheaConfig::Instance()->GetConfigFromDefault("site_path").'/../logs';
$filename = $logsPath."/".$file;

$output = shell_exec("exec tail -n".$lines." ".$filename);  //only print last 50 lines
echo str_replace(PHP_EOL, '<br />', $output);  

?>