<?php

require ("admin_load.php");

$folder = $_POST["folder"];
$plugin_folder = $_POST["plugin_folder"];

$config = null;
	try	{
		$mconfig = new MagratheaConfigFile();
		$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path"));
//		echo "/../".$folder."/plugins/".$plugin_folder."/info.conf";
		$mconfig->setFile("/../".$folder."/plugins/".$plugin_folder."/info.conf");
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
}
$text .= "code: <pre>include(\"plugins/".$plugin_folder."/load.php\");</pre>";

echo $text;

?>

