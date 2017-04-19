<?php

require ("admin_load.php");
$config = MagratheaConfig::Instance();
$fileName = $_POST["name"];

$site_path = $config->GetFromDefault("site_path");
$backupFolder = realpath($site_path."/../database/backups");

if(!is_dir($backupFolder)){
	echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>.../database/backups</b>]<br/> does not exists. Create it with write permissions, please...</div>';
	die;
}

// mysqldump --opt --user=penacova --password=the_6th_sense --host=mysql.paulovelho.com penacova > penacova_20161119.sql

$command = "mysqldump --opt --user=".$config->GetFromDefault("db_user")." --password=".$config->GetFromDefault("db_pass")." --host=".$config->GetFromDefault("db_host")." ".$config->GetFromDefault("db_name")." > ".$backupFolder."/".$fileName.".sql";

system($command, $output);
//$output = shell_exec($commandLine);


if(empty($output)){
	?>
	<div class="alert alert-warning">
		<strong>BACKUP CREATED WITH SUCCESS</strong>
	</div>
	<?php
} else {
	?>
	<div class="alert alert-error">
		<strong>Error running command</strong>
		<br/>
		<br/>command: <pre><?=$command?></pre>
		<br/>error: <pre><?=$output?></pre>
	</div>
	<?php
}
?>
