<?php include("inc/header.php"); ?>

	<h1> .htaccess </h1>
	<p>If you want to develop with mod_rewrite, you will have to configure your .htaccess file in thte app folder of your project.</p>

	<h3>Creating your htaccess file:</h3>
	<p>

		<pre class="prettyprint linenums">
RewriteEngine On

&lt;IfModule mod_rewrite.c&gt;
	RewriteEngine On
	RewriteBase /

	# Do not do anything for already existing files and folders
	RewriteCond %{REQUEST_FILENAME} -f [OR]
	RewriteCond %{REQUEST_FILENAME} -d
	RewriteRule .+ - [L]

	#Respect this rules for redirecting:
	RewriteRule ^([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)/(.*)$ index.php?control=$1&amp;action=$2&amp;params=$3 [QSA,L]
	RewriteRule ^([a-zA-Z0-9_-]+)/(.*)$ index.php?control=$1&amp;action=$2 [QSA,L]
	RewriteRule ^(.*)$ index.php?control=$1 [QSA,L]

&lt;/IfModule&gt;</pre>

	</p>


<?php include("inc/footer.php"); ?>