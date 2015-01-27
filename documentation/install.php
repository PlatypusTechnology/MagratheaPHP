<?php include("inc/header.php"); ?>

	<div class="container main_container">
		<h1> Install </h1>
		<p>Copy the full sample project folder to the directory where your project will be hosted.</p>

		<h2>Create a virtual host</h2>


		<h4>For development in MacOS:</h4>
		<p>
			Working with Mac OSX 10.7:<br/><br/>
			Open the terminal and go to:
			<code>cd /private/etc/apache2/users/</code>, 
			then look for your configuration file (it may be one directory up as well)<br/>
			
			edit that file, adding the following code:

			<pre class="prettyprint linenums">
	&lt;VirtualHost *&gt;
		ServerName magrathea.localhost.com
		ServerAlias magrathea.localhost.com
		DocumentRoot /Users/[user]/Sites/[path]/app
		&lt;Directory /Users/[user]/Sites/[path]/app&gt;
			Options Indexes FollowSymLinks MultiViews
			AllowOverride All
			Order allow,deny
			allow from all
		&lt;/Directory&gt;
	&lt;/VirtualHost&gt;</pre>

			The <code>DocumentRoot</code> should point to the path where the directory was copied. As well the line above.<br/><br/>

			In the terminal, then, go to <code>cd /private/etc/</code> and edit hosts file, adding the line:

			<pre class="prettyprint">127.0.0.1 	magrathea.localhost.com</pre>
			, where <code>magrathea.localhost.com</code> is the internal URL that will be used to reach the website.<br/><br/>

			finally, restart apache, typing in the terminal: <code>sudo apachectl restart</code>

		</p>

		<h3>Initial Configuration</h3>
		<p>
			Remember!<br/>
			You have to start configurating your site path, Magrathea path and database connection, editting the file inside <code>configs/magrathea.conf</code>!<br/>
			For more info about how to edit the configuration file, <a href="config.php">Click here!</a>
		</p>
	</div>


<?php include("inc/footer.php"); ?>