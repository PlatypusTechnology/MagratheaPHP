<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>global.php</h1>
	<p>
		First thing to be looked at every request in the system, the global php will start session, load Magrathea and set whatever else...<br/>
		Inside <em>inc</em> folder at <em>app</em>, the <em>global.php</em> file sets environments and variables for use in the whole application.<br/><br/>
		This is an example of what the global.php file can be:

<pre class="prettyprint linenums">&lt;?php
	// start session:
	session_start();

	// error reporting level:
	error_reporting(E_ALL ^ E_STRICT);

	// set the path of magrathea framework (this way is possible to have only one instance of the framework for multiple projects)
	$magrathea_path = "/Users/paulohenrique/www/magrathea_sample/Magrathea";
	// ... and the path of the site:
	$site_path = "/Users/paulohenrique/www/magrathea_sample";


	// looooooaaaadddiiiiiinnnnnnggggg.....
	include($magrathea_path."/LOAD.php");
	include($magrathea_path."/Smarty/Smarty/Smarty.class.php");

	// wanna debug? here's your debug!
//	MagratheaDebugger::Instance()->SetType("debug");

	// initialize Smarty. eh.. I don't think there is a more beautiful way of doing this
	$Smarty = new Smarty;
	$Smarty->template_dir = $site_path."/app/Views/";
	$Smarty->compile_dir  = $site_path."/app/Views/_compiled";
	$Smarty->config_dir   = $site_path."/app/Views/configs";
	$Smarty->cache_dir    = $site_path."/app/Views/_cache";
	$Smarty->configLoad("site.conf");

	// initialize the MagratheaView and sets it to Smarty	
	$View = new MagratheaView();
	$Smarty->assign("View", $View);

	// for printing the paths of your css and javascript (that will be included in the index.php)
	$View->IsRelativePath(false);

?&gt;</pre><br/>

		As you can see, there are two global variables ($magrathea_path and $site_path). Sorry about that.<br/>
		If <a href="pear.php">pear</a> packages are not installed, you should include the loading of them here, in the beginning of this file.<br/><br/>
		The fun is just starting... Now, let's go to the <a href="indexphp.php">index.php</a>...<br/>

	</p>

</div>

<?php include("inc/footer.php"); ?>