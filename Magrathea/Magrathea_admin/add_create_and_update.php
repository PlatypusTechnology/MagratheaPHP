<?php

require ("admin_load.php");

$table = $_POST["table"];

$queryArray = array();

array_push($queryArray, "ALTER TABLE ".$table." ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;");
array_push($queryArray, "ALTER TABLE ".$table." ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;");

/*
array_push($queryArray, "DROP TRIGGER IF EXISTS ".$table."_create;"); 
array_push($queryArray, "DROP TRIGGER IF EXISTS ".$table."_update;"); 
array_push($queryArray, "CREATE TRIGGER ".$table."_create BEFORE INSERT ON `".$table."` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();");
array_push($queryArray, "CREATE TRIGGER ".$table."_update BEFORE UPDATE ON `".$table."` FOR EACH ROW SET NEW.updated_at = NOW();");
*/

// p_r($queryArray);

try {
	foreach ($queryArray as $q) {
		$result = MagratheaDatabase::Instance()->Query($q);
	}
} catch (Exception $e) {
	echo "error on execution!"; p_r($ex);
	die;
}

?>

