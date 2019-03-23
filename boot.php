<?php
	// delete after use
	// or die:
#	die;

	include("inc/config.php");

	include($magrathea_path."/LOAD.php");
	include($magrathea_path."/MagratheaAdmin.php"); //  should already be declared

	$types = [
		"plugins", 
		"logs", 
		"css-compressed",
		"js-compressed",
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

	echo "site path: [".getPath()."] <br/>";
	echo "PHP running on...  ";
	passthru(id);

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
			echo "\nsudo mkdir ".$path;
			echo "\nsudo chown ".$owner.":".$owner." ".$path;
		}
		echo "</pre>";
		echo "<br/><br/>";
	}

	die;
?>
