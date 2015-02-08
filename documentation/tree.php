<?php include("inc/header.php"); ?>

	<div class="container main_container">
		<h1>Project tree</h1>

	<button class="btn" onClick="window.location.href='https://github.com/PlatypusTechnology/MagratheaSample';">
		<i class="icon-github"></i> View sample project on github
	</button>
	<br/><br/>

Tree:
		<pre>
├───  app
|  ├───  Controls
|  |  └──>  _Controller.php
|  |
|  ├───  css
|  |  ├───  _compressed			// write permission required
|  |  ├───  bootstrap
|  |  └──>  style.css 
|  |
|  ├───  inc
|  |  └──>  global.php
|  |
|  ├───  javascript
|  |  ├───  _compressed			// write permission required
|  |  ├───  bootstrap
|  |  ├───  jquery
|  |  └──>  javascript.js 
|  |
|  ├───  Models 
|  |  └───  Base 		// write permission required
|  | 
|  ├───  Views
|  |  ├───  _cache			// for Smarty use
|  |  ├───  _compiled		// for Smarty use
|  |  └───  configs			// for Smarty use
|  |     └──>  site.conf 		// for Smarty use
|  | 
|  ├──>  admin.php
|  └──>  index.php
|
├───  configs 			// write permission required
|  ├──>  index.html 		// empty file
|  ├──>  magrathea.conf 		// based on magrathea.conf.default
|  └──>  magrathea_objects.conf
|
├───  Magrathea  		// Magrathea framework
|  └─── libs
|  |  ├───  pear	 		// pear
|  |  └───  Smarty 			// Smarty
|  └─── Magrathea Admin 
|		// Magrathea Admin
├───  plugins 			// write permission required
└───  Tests
</pre>

	<br/>
	<em>app</em> folder is where the app is located
	<br/><br/>

	<button class="btn" onClick="window.location.href='https://github.com/PlatypusTechnology/MagratheaSample';">
		<i class="icon-github"></i> View sample project on github
	</button>

    </div>

<?php include("inc/footer.php"); ?>