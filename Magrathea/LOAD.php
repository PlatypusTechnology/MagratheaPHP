<?php

$path = __DIR__."/";
require ($path."Exceptions.class.php");
require ($path."Functions.php");
require ($path."Database.class.php");
require ($path."Config.class.php");
require ($path."Controller.class.php");
require ($path."Model.class.php");
require ($path."ModelControl.class.php");
require ($path."View.class.php");

include ($path."MagratheaCompressor.php");
require ($path."MagratheaQuery.php");
require ($path."MagratheaDebugger.php");
require ($path."MagratheaLogger.php");

include("load_vars.php");

?>