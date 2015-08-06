<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Custom Admin</h1>
	<p>
		You can create custom admin pages and functions for an easy administration for your project.<br/>
		For this, just include some files inside <em><b>Admin</b></em> folder.
	</p>
	<h3>menu.php</h3>
	<p>
		The menu.php file will be looked for into <em><b>Admin</b></em> folder for displaying the list of options inside Magrathea Admin.<br/>
		menu.php sample:
		<pre class="prettyprint linenums">
&lt;ul&gt;
	&lt;li&gt;&lt;a href="add_object.php"&gt;&lt;i class="fa fa-plus-circle"&gt;&lt;/i&gt; Add Object&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href="list_object.php"&gt;&lt;i class="fa fa-bars"&gt;&lt;/i&gt; List objects&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;</pre>
		The files related on the link should be inside <em><b>Admin</b></em> folder as well.
	</p>
	<h3>Files</h3>
	<p>
		You don't need to load default configuration for any file loaded on Magrathea Admin.<br/>
		Everything should already be locked and loaded, just start your objects:
		<pre class="prettyprint linenums">
&lt;?php
	
	$objects = ObjectControl::GetAll();
	p_r($objects);

?&gt;
</pre>
		Easy as that!
	</p>
	<h3>Javascript calls</h3>
	<p>
		Any page called inside MagratheaAdmin should be done via Ajax using Magrathea's Admin own function:<br/>
<pre class="prettyprint linenums">
function MagratheaPost(page, data, callback){
	/* magic code here */

	if(!callback){
		callback = function(data){
			$("#main_content").html(data);
			scrollToTop();
		};
	}
	$.ajax({
		url: url, type: "POST", data: data,
		success: callback
	});
}</pre>
		The parameters to be sent are:<br/>
		<ul>
			<li><b>page</b>: the page inside Magrathea Admin to be called.</li>
			<li><b>data</b>: the data to be sent to that page via post.</li>
			<li><b>callback</b>: after getting result from the page, callback will be called with the return data. If callback is not sent, the requested page will be loaded in the main page.</li>
		</ul>
		Any other javascript for the page should be added inside &lt;script&gt; tags in the pages inside Admin.
	</p>
	<p>
		If dropbox plugin is included in custom admin, you can as well call some of the adapted ColorBox functions:<br/>
<pre class="prettyprint linenums">
function ColorBox(page, options){
	/* magic code here */

	options.href = page;
	$.colorbox(options);
}
function ColorBoxDo(action){
	switch(action){
		case "close":
		$.colorbox.close()
	}
}</pre>
		The parameters for <i>ColorBox</i> are: <br/>
		<ul>
			<li><b>page</b>: the page inside Magrathea Admin to be called.</li>
			<li><b>options</b>: options for color box
		</ul>
		<br/>
		And the actions so far available in <i>ColorBoxDo</i> is only "close".
	</p>
	<h3>Magrathea Admin</h3>
	<p>
		Lots of possibilities can be done with the <a href="class-MagratheaAdmin.html.php">MagratheaAdmin</a> object.<br/>
		From it, you can include Magrathea Plugins in the code, include custom CSS, define titles and vars and create more complex administration systems.<br/>
	</p>
</div>


<?php include("inc/footer.php"); ?>