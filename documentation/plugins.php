<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Plugins</h1>
	<p>
		Plugins allow you to install some functionalities in your project without worrying about copying a lot of files or anything like that.
	</p>
	<h3>Adding a new plugin</h3>
	<p>
		All plugins listed can be found at <b><em>Magrathea/plugins</em></b>.<br/>
		Folder's name are correspondent to plugin's name and, basically, Magrathea will copy the content of it to your project.<br/>
		<div class="alert alert-block">
		Be sure that your plugins folder (app/plugins) have the correct permissions to be written!
		</div>
		After installing it, you should call the plugin data from your code - example, adding the following to index.php:
		<pre class="prettyprint linenums">include("plugins/angular/load.php");</pre>
	</p>
	<h3>Create your own plugins</h3>
	<p>
		When creating a new plugin, you have to include a file <b><em>info.conf</em></b> that will get information to be displayed on the Plugins Page:
		<pre>
name = "angular JS"
version = "1.3.13"
description = "angularJS - v. 1.3.13 + dozens of additional modules. &lt;br/&gt;Includes extra modules: animate; aria; cookies; csp; loader; messages; mocks; resource; route; sanitize; scenario; touch"
url = "http://angularjs.org/"
author = "Google"
more = ""
database = "database/db.sql"</pre>
	</p>
	<h3>Available plugins (so far):</h3>
	<ul>
		<li>angular</li>
		<li>bootstrap</li>
		<li>bootstrap2</li>
		<li>colorbox</li>
		<li>dropzone</li>
		<li>font-awesome</li>
		<li>font-awesome4</li>
		<li>ibutton</li>
		<li>jquery</li>
		<li>jquery-ui</li>
		<li>jquery-validation</li>
		<li>jquery1.7</li>
		<li><a href="plugins_magratheaImage.php">MagratheaImages2<a/></li>
	</ul>
</div>

<?php include("inc/footer.php"); ?>