<?php

require ("admin_load.php");

$backupFolder = realpath($site_path."/../database/backups");

if(!is_dir($backupFolder)){
	echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>.../database/backups</b>]<br/> does not exists. Create it with write permissions, please...</div>';
	die;
}

?>

