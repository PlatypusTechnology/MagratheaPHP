<?php

	if(session_id() == '')
		session_start();


  if(isset($_POST["new_config_section"])){
    $_SESSION["config_section"] = $_POST["new_config_section"];
  }
  if(isset($_SESSION["config_section"])){
  	$GLOBALS['environment'] = $_SESSION["config_section"];
  }

  require (__DIR__."/../Magrathea/load_vars.php");
  require ("admin_functions.php");

?>