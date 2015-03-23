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
	// or you may prefer insert everything at once, using Magrathea's awesome functions:
	MagratheaController::IncludeAllControllers();
	MagratheaModel::IncludeAllModels();


	// let's include some of Magrathea's awesome plugins:
	include("plugins/jquery/load.php");
	include("plugins/bootstrap/load.php");
	include("plugins/font-awesome4/load.php");
	// we already have a bunch of them! =)

	// let's include CSS and JavaScript for the page:
	try {
		MagratheaView::Instance()
		->IncludeCSS("css/style.css")
		->IncludeJavascript("javascript/script.js");
	} catch(Exception $ex){
		// probably the file does not exists. What to do now?
	}


	// Magrathea Route will get the path to the correct method in the right class:
	MagratheaRoute::Instance()
		->Route($control, $action, $params);


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