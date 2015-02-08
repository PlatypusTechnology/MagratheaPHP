<?php
include("inc/header.php");

$class = $_GET["class"];
include("classes/".$class.".html");

include("inc/footer.php");
?>