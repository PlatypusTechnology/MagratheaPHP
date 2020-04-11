<?php include("inc/header.php"); ?>

	<div class="container main_container">
		<img src="https://s3.amazonaws.com/cloud.ohloh.net/attachments/2264/logo_pear_med.gif" alt="Pear" title="Pear" class="image right"/>
		<h1>pear</h1>

		Pear is an extension and application repository. Documentation and installation available at: <a href="http://pear.php.net/" target="_blank">http://pear.php.net/ <i class="icon-external-link"></i></a>.
		<br/><br/>

		Magrathea uses some libraries:
		<br/><br/>

		<h4>MDB2</h4>
		A database abstraction layer. Available at <a href="http://pear.php.net/package/MDB2" target="_blank">http://pear.php.net/package/MDB2 <i class="icon-external-link"></i></a>
		<br/><br/>

		<h4>Mail</h4>
		Interfaces for sending emails (only necessary if <a href="class-MagratheaEmail.html.php"><em>MagratheaEmail</em></a> will be used).
		Available at <a href="http://pear.php.net/package/Mail" target="_blank">http://pear.php.net/package/Mail <i class="icon-external-link"></i></a>
		<br/><br/>

		<h2>Auto-include</h2>
		If you don't want to download or install pear, you can follow this sample to include it automatically in your project:<br/>
		<a href="https://github.com/PlatypusTechnology/MagratheaSample/tree/master/pear" target="_blank">https://github.com/PlatypusTechnology/MagratheaSample/tree/master/pear ( <i class="icon-github-alt"></i> <i class="icon-external-link"></i> )</a><br/>
		, and add the following code in the first lines of <a href="globalphp.php">global.php</a>:<br/>
<pre class="prettyprint linenums">set_include_path(".".PATH_SEPARATOR.("/Users/username/pear/php".PATH_SEPARATOR.get_include_path()));</pre>
		<br/>
		<b>Could I just include the pear libraries in Magrathea's code and get you rid of all this work?</b><br/>
		Yes. I could. But, if you already use Pear, then you don't get repeated code in your project. And pear guys must get their credit. And it's not this hard, c'mon, man!<br/><br/>




    </div>

<?php include("inc/footer.php"); ?>