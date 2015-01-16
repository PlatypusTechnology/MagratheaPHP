<?php

require ("admin_load.php");

error_reporting(E_ALL);

$query = $_POST["sql"];
$queryArr = explode(";", $query);

@$result = $magdb->QueryTransaction($queryArr);
//p_r($result);

?>

<div class="alert alert-success">
	<button class="close" data-dismiss="alert" type="button">×</button>
	<strong>Query executed!</strong><br/>
	Query: <br/>
	<? p_r($query); ?>
</div>
