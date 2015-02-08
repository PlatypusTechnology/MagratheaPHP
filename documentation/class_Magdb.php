<?php include("inc/header.php"); ?>

	<h1>Magdb Class</h1>
	<p>
		This class will provide you all the tools necessary for accessing the database
	</p>

	<h3>Content</h3>
	<p>
		<ul>
			<li><a href="#configuration">Configuring database</a></li>
			<li><a href="#details">Using details</a></li>
			<li><a href="#Instance">Instance();</a></li>
			<li><a href="#SetConnectionArray">SetConnectionArray($dns_arr);</a></li>
		</ul>
	</p>


	<a name="configuration"></a>
	<h3>Setting Up Database</h3>
	<p>
		[Setting up details]
	</p>

	<a name="details"></a>
	<h3>Details</h3>
	<p>
		Magdb can be used as a Singleton.<br/>
		This means that only an instance of the class will be created and all the code will be able to use the same instance.
	</p>



	<h3>Functions</h3>

	<a name="Instance"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"><span class="function_static">static</span> Instance();</span>
	</h5>
	<p class="function">
		<br/><em>Returns:</em><br/>
		Magdb Object.<br/>
		<br/><em>Use:</em><br/>
		The function should be called statically.<br/>
		This function will return the current Magdb instance in use.<br/>
		<br/><em>Example:</em></br>
		<pre class="prettyprint linenums lang-php">
	$databaseObj = Magdb::Instance();</pre>
	</p>

	<a name="SetConnectionArray"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"> SetConnectionArray(<span class="function_param">$dns_arr</span>=<span class="var_string">""</span>);</span>
	</h5>
	<p class="function">
		<br/><em>Parameters:</em><br/>
		<span class="function_param">$dns_arr</span> (<span class="var_array">array</span>): .<br/>
		<br/><em>Use:</em><br/>
		The function should be called statically.<br/>
		<span class="function_param">$config_name</span> can be called to get a parameter from inside a section of the config file. 
		To achieve this, you should use a slash (/) to separate the section from the property.<br/>
		If the slash is not used, the function will return the property only if it's on the root.<br/>
		If <span class="function_param">$config_name</span> is a section name, the function will return the full section as an Array.<br/>
		If <span class="function_param">$config_name</span> is empty, the function will return the full config as an Array (<b>not recommended!</b>).<br/>
		<br/><em>Example:</em></br>
		<pre class="prettyprint linenums lang-php">
	$environment = MagratheaConfigStatic::GetConfig("general/use_environment");</pre>
		- this code will return the environment that is signed as in use in the <code>magrathea.conf</code> file.
	</p>







<?php include("inc/footer.php"); ?>