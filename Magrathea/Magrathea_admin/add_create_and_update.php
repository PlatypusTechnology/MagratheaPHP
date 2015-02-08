<?php

require ("admin_load.php");

$table = $_POST["table"];

$queryArray = array();

array_push($queryArray, "ALTER TABLE ".$table." ADD created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00', ADD updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00'; ");
array_push($queryArray, "DROP TRIGGER IF EXISTS ".$table."_create;"); 
array_push($queryArray, "DROP TRIGGER IF EXISTS ".$table."_update;"); 
array_push($queryArray, "CREATE TRIGGER ".$table."_create BEFORE INSERT ON `".$table."` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();");
array_push($queryArray, "CREATE TRIGGER ".$table."_update BEFORE UPDATE ON `".$table."` FOR EACH ROW SET NEW.updated_at = NOW();");

p_r($queryArray);

$magdb->QueryTransaction($queryArray);

?>

