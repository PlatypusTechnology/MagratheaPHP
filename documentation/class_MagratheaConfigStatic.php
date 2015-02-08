<?php include("inc/header.php"); ?>

	<h1>MagratheaConfigStatic Class</h1>
	<p>
		This class will provide you the quickest access possible to the <code>magrathea.conf</code> <a href="config.php">config file</a>.<br/>
	</p>

	<h3>Content</h3>
	<p>
		<ul>
			<li><a href="#GetEnvironment">GetEnvironment();</a></li>
			<li><a href="#GetConfig">GetConfig($config_name);</a></li>
			<li><a href="#GetConfigFromDefault">GetConfigFromDefault($config_name);</a></li>
			<li><a href="#GetConfigSection">GetConfigSection($section_name);</a></li>
		</ul>
	</p>





	<h3>Functions</h3>

	<a name="GetEnvironment"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"><span class="function_static">static</span> GetEnvironment();</span>
	</h5>
	<p class="function">
		<br/><em>Returns:</em><br/>
		String.<br/>
		<br/><em>Use:</em><br/>
		The function should be called statically.<br/>
		This function will return the environment being used in the project.<br/>
		The environment is defined in <code>general/use_environment</code> property and can be defined in the <code>magrathea.conf</code> file.
		<br/><em>Example:</em></br>
		<pre class="prettyprint linenums lang-php">
	$environment = MagratheaConfigStatic::GetEnvironment();</pre>
	</p>

	<a name="GetConfig"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"><span class="function_static">static</span> GetConfig(<span class="function_param">$config_name</span>=<span class="var_string">""</span>);</span>
	</h5>
	<p class="function">
		<br/><em>Parameters:</em><br/>
		<span class="function_param">$config_name</span> (<span class="var_string">string</span>): Item to be returned from the magrathea.conf.<br/>
		<br/><em>Returns:</em><br/>
		Array or String.<br/>
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

	<a name="GetConfigFromDefault"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"><span class="function_static">static</span> GetConfigFromDefault(<span class="function_param">$config_name</span>);</span>
	</h5>
	<p class="function">
		<br/><em>Parameters:</em><br/>
		<span class="function_param">$config_name</span> (<span class="var_string">string</span>): Item to be returned from the magrathea.conf.<br/>
		<br/><em>Returns:</em><br/>
		String.<br/>
		<br/><em>Use:</em><br/>
		The function should be called statically.<br/>
		This function will get the <span class="function_param">$config_name</span> property from magrathea.conf.<br/>
		It will get from the section defined on <code>general/use_environment</code>.
	</p>

	<a name="GetConfigSection"></a>
	<hr/>
	<h5>
		<i class="icon-chevron-right"></i><span class="function_title"><span class="function_static">static</span> GetConfigSection(<span class="function_param">$section_name</span>);</span>
	</h5>
	<p class="function">
		<br/><em>Parameters:</em><br/>
		<span class="function_param">$section_name</span> (<span class="var_string">string</span>): Name of the <b>section</b> to be returned from the magrathea.conf.<br/>
		<br/><em>Returns:</em><br/>
		Array.<br/>
		<br/><em>Use:</em><br/>
		The function should be called statically.<br/>
		<span class="function_param">$section_name</span> is the name of the section that will be returned as an array.</br>


<?php include("inc/footer.php"); ?>