<?php
	require ("admin_load.php");

	$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
	$backupFolder = realpath($site_path."/../database/backups");
	$dbFile = $_GET["db_file"];
	$filename = $backupFolder."/".$dbFile;

	header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\"");
	header("Content-Type: application/force-download");
	header("Content-Length: " . filesize($filename));
	header("Connection: close");

	readfile($filename);
?>
