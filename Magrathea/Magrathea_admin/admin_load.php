<?php

	if(session_id() == '')
		session_start();

  $environment = MagratheaConfig::Instance()->GetEnvironment();

  require (__DIR__."/../load_vars.php");
  require ("admin_functions.php");

?>