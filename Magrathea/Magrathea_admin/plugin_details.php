<?php

require ("admin_load.php");

$plugin_folder = $_POST["plugin_folder"];

$config = null;
	try	{
		$mconfig = new MagratheaConfigFile();
		$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path"));
		$mconfig->setFile("/plugins/".$plugin_folder."/info.conf");
		$config = $mconfig->getConfig();
	} catch (Exception $ex){
		$error_msg = "Error: ".$ex->getMessage();
	}

$text = "";
if(is_null($config)){
	$text = "Could not load the data from info.conf!<br/><br/>(maybe the file doesn't exists...)";
} else {
	$text .= "<h4>".$config["name"]."</h4>";
	$text .= "<p>author: <strong>".$config["author"]."</strong><br/>version: <em>".$config["version"]."</em><br/></p>";
	$text .= "<p>".$config["description"]."</p>";
	if( !empty($config["url"]) )
		$text .= "<p><a href='".$config["url"]."'>".$config["url"]."</a></p>";
	if(!empty($config["more"]))
		$text .= "<p><pre>".$config["more"]."</pre></p>";
	if(@!empty($config["database"])){
		$queryUrl = MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path")."/plugins/".$plugin_folder."/".$config["database"];
		$query = file_get_contents($queryUrl);
		$database = '<div class="row-fluid"><div class="span12">';
		$database .= '<button class="btn btn-default" onClick="$(this).hide(\'slow\'); $(\'#'.$plugin_folder.'_db\').show(\'slow\');"><i class="fa fa-database"></i>&nbsp;Plugin database</button>';
		$database .= '<div id="'.$plugin_folder.'_db" style="display: none;"><textarea class="textarea_large" id="'.$plugin_folder.'_query">'.$query.'</textarea><br/>';
		$database .= '<button class="btn btn-success" onClick="pluginQueryRun(\''.$plugin_folder.'\');"><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;Run Query</button>';
		$database .= "</div></div></div>";
	}
}
$text .= "code: <pre>include(\"plugins/".$plugin_folder."/load.php\");</pre>";

if(@$database)
	$text .= $database;

echo $text."<br/><br/>";

?>

