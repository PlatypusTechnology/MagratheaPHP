
<?php

require ("admin_load.php");

$types = [
	"plugins", 
	"logs", 
	"css-compressed",
	"js-compressed",
	"smarty",
	"smarty-compiled",
	"smarty-configs",
	"smarty-cache",
	"static"
	];

function checkPath($type) {
	$path = getPathByType($type);

	echo $type." path: [".$path."]<br/>";
	echo " - ";
	if (!isDirOk($path)) {
		echo "<br/> - <a href='?call=bootup&action=create&path=".$type."'>[create]</a>";
	}
	echo "<br/><hr/>";
}

function create($type) {
	$path = getPathByType($type);
	echo " - ...creating [".$path."]<br/>";
	changeOwner();
//	$owner = folderOwner();
//	echo "owner ".$owner;
}

function isDirOk($path) {
	$isThere = is_dir($path) && is_writable($path);
	echo printBoolean($isThere);
	return $isThere;
}
function printBoolean($bool) {
	return $bool ? "(( true ))" : "(( false ))";
}
function getPathByType($type) {
	$site_path = getPath();
	switch ($type) {
		case "plugins":
			return $site_path."/app/plugins";
		case "css-compressed":
			return $site_path."/app/".MagratheaView::Instance()->GetCompressedPathCss();
		case "js-compressed":
			return $site_path."/app/".MagratheaView::Instance()->GetCompressedPathJs();
		case "logs":
			return $site_path."/logs";
		case "static":
			return $site_path."/Static";
		case "smarty":
			return $site_path."/smarty";
		case "smarty-compiled":
			return $site_path."/smarty/compiled";
		case "smarty-cache":
			return $site_path."/smarty/cache";
	}
	return "";
}
function getPath() {
	$site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
	return realpath($site_path."/..");
}
function commandToPath($type) {
}

$action = @$_GET["action"];
if ( $action == "create" ) {
	$type = @$_GET["path"];
	echo "creating path for [".$type."]... <br/><br/><br/>";
	create($type);
	echo "<hr/>";
}

if ($action == "command") {
	echo "<br/><br/><hr/>";
	echo "<pre>";
	$owner = @$_GET["owner"];
	if ( empty($owner) ) {
		echo "\n\nplease, help us filling up php owner\n\n";
		echo "\nps aux | grep httpd";
		echo "\n&owner=";
	} else { 
		foreach ($types as $t) {
			$path = getPathByType($t);
			echo "\nmkdir ".$path;
		}
		foreach ( array_reverse($types) as $t) {
			$path = getPathByType($t);
			echo "\nsudo chown ".$owner." ".$path;
		}
	}
	echo "</pre>";
	echo "<br/><br/>";
}

echo "checking paths... <br/><br/><br/>";
foreach ($types as $t) {
	checkPath($t);
}
echo "<br/> - <a href='?call=bootup&action=command'>[commands]</a>";

die;


?>