<?php

require ("admin_load.php");

error_reporting(E_ALL);

$query = $_POST["sql"];
$queryArr = explode(";", $query);

@$result = $magdb->QueryAll($queryArr);
//p_r($result);

?>

<div class="alert alert-success">
	<button class="close" data-dismiss="alert" type="button">×</button>
	<strong>Query executed!</strong><br/>
	Query: <br/>
	<? p_r($query); ?><br/>
	Result: <br/>
	<textarea class="textarea_large"><?=$result?></textarea><br/>
	Extended Result: <br/>
	<textarea class="textarea_large"><?=print_r($result)?></textarea><br/>
</div>
