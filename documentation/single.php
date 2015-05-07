<?php include("inc/header.php"); ?>

	<div class="container main_container">
		<h1>Magrathea Singles</h1>
		<p>
			Sometimes we don't need a full project, with lots of pages, two thousand functionalities and an awesome layout.<br/>
			Sometimes, all we need is a PHP script that does something and, maybe, prints a json file or saves humanity.<br/><br/>
			If you want to use all Magrathea's power for it, you also can do. Build a Magrathea Single.<br/><br/>
			All you have to do is to declare the variable <em>$magratheaSingle</em> as true before loading it:

<pre class="prettyprint linenums">&lt;?php

	$magratheaSingle = true; 
	$magrathea_path = "/Users/path/to/Magrathea";
	include($magrathea_path."/LOAD.php");

	// for database connection:
	$db = MagratheaDatabase::Instance()->SetConnection("127.0.0.1", "mydb", "root", "password123");
	// as we don't have the log files, we ask for it to print the debug
	// but you can ask for log everything somewhere else! (see: MagratheaConfig)
	MagratheaDebugger::Instance()->SetType(MagratheaDebugger::DEBUG); 

	// from now on, it's with you!

	$sql = "SELECT * FROM tbl_user";
	$rs_user = $db->QueryAll($sql);

	// ...

?&gt;</pre><br/>
	
			Magrathea Singles doesn't start databases, config files or Smarty objects, so this is up to you. All classes, functions and other functionalities are available.<br/><br/>
			Sometimes it's good some simplicity. =)

		</p>

	</div>

<?php include("inc/footer.php"); ?>