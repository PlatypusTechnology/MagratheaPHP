<?php include("inc/header.php"); ?>

<?php

	$page = $_GET["p"];
	if(empty($page)) $page = "index.html";
	include("docs/".$page);

?>
