<?php

require ("admin_load.php");

$types = [
	"plugins", 
	"logs", 
	"css",
	"js",
	"css-compressed",
	"js-compressed",
	"controls",
	"views",
	"smarty",
	"smarty-compiled",
	"smarty-cache",
	"static"
	];

function checkPath($type) {
	$path = getPathByType($type);

	echo $type." path: [".$path."]<br/>";
	echo " - ";
	$dirok = isDirOk($path);
	echo printBoolean($dirok);
	if (!$dirok) {
		echo "<br/> - <a href='?call=bootup&action=create&path=".$type."'>[create]</a>";
	}
	echo "<br/><hr/>";
}

function create($type) {
	$path = getPathByType($type);
	echo " - ...creating [".$path."]<br/>";
	if(!mkdir($path, 0755)) {
		echo "FAIL";
	}
}

function isDirOk($path) {
	$isThere = is_dir($path) && is_writable($path);
	return $isThere;
}
function printBoolean($bool) {
	return $bool ? "(( true ))" : "(( false ))";
}
function getPathByType($type) {
	$site_path = getSitePath();
	$path = getPath();
	switch ($type) {
		case "plugins":
			return $site_path."/plugins";
		case "css":
			return $site_path."/css";
		case "js":
			return $site_path."/javascript";
		case "css-compressed":
			return $site_path."/".MagratheaView::Instance()->GetCompressedPathCss();
		case "js-compressed":
			return $site_path."/".MagratheaView::Instance()->GetCompressedPathJs();
		case "logs":
			return $path."/logs";
		case "static":
			return $path."/Static";
		case "controls":
			return $path."/Controls";
		case "Views":
			return $path."/Views";
		case "smarty":
			return $path."/Views/_configs";
		case "smarty-compiled":
			return $path."/Views/_compiled";
		case "smarty-cache":
			return $path."/Views/_cache";
	}
	return "";
}
function getSitePath() {
	return MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
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

echo "<br/>";
echo "environmment: [".MagratheaConfig::Instance()->GetEnvironment()."] <br/>";
echo "site path: [".getPath()."] <br/>";
echo "PHP running on...  ";
//passthru(id);

echo "<br/><hr/>";

echo "checking paths... <br/><br/><br/>";
foreach ($types as $t) {
	checkPath($t);
}
echo "<br/> - <a href='?call=bootup&action=generate_sh'>[generate sh]</a>";

if ($action == "generate_sh") {
	echo "<br/><br/><hr/>";
	echo "<pre>";

	$owner = shell_exec( 'whoami' );
	$owner = trim($owner);
	foreach ($types as $t) {
		$path = getPathByType($t);
		if(isDirOk($path)) continue;
		echo "\nmkdir ".$path;
//		echo "\nchown ".$owner.":".$owner." ".$path;
	}
	echo "</pre>";
	echo "<br/><br/>";
}

die;


?>