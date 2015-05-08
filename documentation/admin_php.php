<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Admin.php</h1>
	<p>
		After the project is installed, you should be able to access the admin, simply going to <code>your.project/admin.php</code><br/><br/>
		The admin.php will give you all the tools for you to configurate your project and database and internal development relations etc. It will even create the initial code for you to keep developing...<br/><br/>
<pre class="prettyprint linenums">&lt;?php
	include("inc/global.php");
	include($magrathea_path."/MagratheaAdmin.php"); // $magrathea_path should already be declared

	$admin = new MagratheaAdmin(); // adds the admin file
	$admin->Load(); // load!
?&gt;</pre>
	Easy as that...
	</p>

	<h3>Admin tools</h3>
	<p>
		Look at your left. There, you see? That beautifull bootstrap menu. You already have all those tools available for you.<br/>
		
		<h5><i class="icon-cogs"></i> Configuration</h5>
		Ok! Let's start! First thing you have to setup in your brand new project is the configuration.<br/>
		I hope that you already did this in the <a href="config.php">config file</a>, but here you can review the information that the project is using and even test the database connection.<br/>
		Honestly, you are going to use this section more as a verification that everything is right than to edit information - what may be easier to do directly in the config file... ;)<br/>
		
		<h5><i class="icon-table"></i> Tables</h5>
		Here things start to get interesting.<br/>
		The tables from your mysql connection might be available here. And you can create information from them directly from the admin!<br/>
		Too much win!<br/>
		For information about table management and converting them into objects, <a href="admin_tables.php">go here</a>!<br/>
		
		<h5><i class="icon-list"></i> Table Data</h5>
		Execute simple queries, play a little bit with <a href="class-MagratheaQuery.html.php"><i>MagratheaQuery</i></a>, see some rows, drink some vodkas... anyway, I should work better on this section, I know...<br/>
		
		<h5><i class="icon-inbox"></i> Objects</h5>
		What would be of our Object Oriented Programming without objects!?<br/>
		Nothing! It's like internet without porn. Has no purpose of existing!<br/>
		Here you can see all the objects created, manage relations between them, check default properties...<br/>
		Yes! Too much! That's why <a href="admin_objects.php"><i>objects</i> are explained in more details in its own page</a>...<br/>

		<h5><i class="icon-pencil"></i> Generate Code</h5>
		Look how awesome: Magrathea is even writing the code for you!<br/>
		Ok, it's just the base code for the objects and it may not do much, but, camon! It's a framework that codes by itself.<br/>
		(more info about this also in <a href="admin_objects.php">objects</a>)

		<h5><i class="icon-bullseye"></i> Plugins</h5>
		Plugins! Plugins! Plugins!<br/>
		Because less work you have, better for you!<br/>
		<a href="plugins.php">Check the plugins page</a>!<br/>

		<h5><i class="icon-reorder"></i> Database</h5>
		Now we have some kind of reverse engineering here.<br/>
		This section will get the objects that you have available in your project and generate the simplest code possible for creating mysql queries for tables and triggers for them.<br/>
		It may not be the best code possible, for that reason, we advise you to keep a mysql dump with the database, but it's something you can work on if everything else fails<br/>

		<h5><i class="icon-file"></i> Logs</h5>
		Logs are available here - even with an option of auto-update a specific log file.<br/>
		...because sometimes we are too lazy to open explorer/terminal...<br/>

		<h5><i class="icon-sitemap"></i> Validate Structure</h5>
		Everything is crashing! Nothing is working! I'm getting white screens! Are my permissions and folder structure correct?<br/>
		Here we make some tests verifications to see if your directories are well set up.<br/>
		If you are facing an unknown error, you might find some problem-solvers here.<br/>

		<h5><i class="icon-beaker"></i> Tests</h5>
		Please, tell me that you have the habit of writing tests...<br/>
		No? Ok, me neither, but it would be great if we had, right!?<br/>
		Here we have some tools that makes this job easier... Just trying to eliminate some excuses that we give ourselves for not doing it...<br/>
		More information about it on <a href="admin_tests.php">tests page</a>.<br/>

		<h5><i class="icon-dashboard"></i> Custom Admin</h5>
		This is great!<br/>
		If all you need is a simple admin for some quick tasks without a killer layout, we can provide you the quickest way to do so.<br/>
		<a href="admin_tests.php">We have a section explaining it</a>. I bet you will like! ;)<br/>
		
		<h5><i class="icon-info-sign"></i> PHP info</h5>
		<pre>phpinfo();</pre>
		Because we always need it sooner or later...<br/>

	</p>
</div>


<?php include("inc/footer.php"); ?>