<?php include("inc/header.php"); ?>

	<div class="container main_container">
		<img src="http://www.smarty.net/images/logo_print.gif" alt="Smarty" title="Smarty" class="image right"/>
		<h1>Smarty</h1>

		The template engine used in Views for Magrathea is Smarty.<br/>
		Smarty was choosen because it is clean, fast, quick to learn and easy to maintain.<br/>
		<br/>

		The engine website is <a href="http://www.smarty.net/" target="_blank">http://www.smarty.net/ <i class="icon-external-link"></i></a> and its documentation is also available <a href="http://www.smarty.net/documentation" target="_blank">there <i class="icon-external-link"></i></a>.
		<br/><br/>
		Smarty library is available inside <em>Magrathea/libs</em>, so, if you want to use another version or change anything on it, be my guest!<br/><br/>

		Some sample of how to load Smarty object can be found on <a href="globalphp.php">global.php</a> file, but, if you want some spoilers of what will be necessary to do, here it is:<br/>
<pre class="prettyprint linenums">
	$Smarty = new Smarty;
	$Smarty->template_dir = $site_path."/app/Views/";
	$Smarty->compile_dir  = $site_path."/app/Views/_compiled";
	$Smarty->config_dir   = $site_path."/app/Views/configs";
	$Smarty->cache_dir    = $site_path."/app/Views/_cache";
	$Smarty->configLoad("site.conf");

	// initialize the MagratheaView and sets it to Smarty	
	$View = new MagratheaView();
	$Smarty->assign("View", $View);
</pre><br/>		

    </div>

<?php include("inc/footer.php"); ?>