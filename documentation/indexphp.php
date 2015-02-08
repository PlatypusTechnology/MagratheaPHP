<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>index.php</h1>
	<p>
		Here we are! To the hearth of your project. If you're creating Apple, this file is your Steve Jobs.<br/><br/>
		The <em>index.php</em> is the entrance hall of your project and will include everything that may be used, as the models, controls, resources and Magrathea Plugins.<br/>
		This is a sample of code that you might find in index.php:
		<pre class="prettyprint linenums">&lt;?php

	// let's include global!
	include("inc/global.php");

	// let's include all the classes we're gonna use!
	include("Controls/_Controller.php");
	include("Controls/Home.php");
	include("Models/Users.php");
	include("Models/Products.php");

	// let's include CSS and JavaScript for the page:
	$View->IncludeCSS("css/style.css");
	$View->IncludeJavascript("javascript/jquery/jquery.min.js");
	$View->IncludeJavascript("javascript/script.js");

	// let's include plugins:
	include("plugins/Font-awesome/load.php");

	// set default Controls:
	$control = "Home";
	$action = "Index";
	$params = array();

	if(isset($_GET["control"]) && !empty($_GET["control"])) $control = $_GET["control"];
	if(isset($_GET["action"]) && !empty($_GET["action"])) $action = $_GET["action"];
	if(isset($_GET["params"]) && !empty($_GET["params"])) $params = $_GET["params"];

	try{
		// looooooaad!
		MagratheaController::Load($control, $action, $params);
	} catch (Exception $ex) {
		// in case of error, it can be treated here. 
		// you can control the 404 error here as well!
		BaseControl::Go404();
	}

?&gt;</pre>
	</p>

</div>

<?php include("inc/footer.php"); ?>