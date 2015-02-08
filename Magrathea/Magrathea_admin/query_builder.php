<?php

require ("admin_load.php");
MagratheaModel::IncludeAllModels();

error_reporting(1);

$code = $_POST["exec"];
eval("\$query = ".$code);
echo $query;

?>