<?php

require ("admin_load.php");
MagratheaModel::IncludeAllModels();

error_reporting(1);

$code = $_POST["exec"];
eval("\$query = ".$code);

if(!empty($code) && empty($query)){
	echo "Error on code";
} else {
	echo $query;
}

?>