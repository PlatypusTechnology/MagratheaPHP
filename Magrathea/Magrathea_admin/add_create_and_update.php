<?php

require ("admin_load.php");

$table = $_POST["table"];

$queryArray = array();

array_push($queryArray, "ALTER TABLE ".$table." ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;");
array_push($queryArray, "ALTER TABLE ".$table." ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;");

try {
	foreach ($queryArray as $q) {
		$result = MagratheaDatabase::Instance()->Query($q);
	}
} catch (Exception $e) {
	echo "error on execution!"; p_r($ex);
	die;
}

?>

