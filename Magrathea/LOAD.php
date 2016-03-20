<?php

$path = __DIR__."/";
include_once($path."libs/Smarty/Smarty.class.php");
include_once($path."libs/WideImage/WideImage.php");

// database changing:
//require ($path."Database.php");
require ($path."MagratheaDatabase.php");


require ($path."Exceptions.php");
require ($path."MagratheaConfig.php");
require ($path."MagratheaController.php");
require ($path."MagratheaModel.php");
require ($path."MagratheaModelControl.php");
require ($path."MagratheaView.php");

include ($path."MagratheaCompressor.php");
require ($path."MagratheaQuery.php");
require ($path."MagratheaDebugger.php");
require ($path."MagratheaLogger.php");

require ($path."Functions.php");

include ($path."MagratheaRoute.php");

if(@$magratheaSingle !== true)
	include("load_vars.php");

?>
