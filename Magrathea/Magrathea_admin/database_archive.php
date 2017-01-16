<?php

require ("admin_load.php");

error_reporting(E_ALL);

$query = $_POST["sql"];
$tableName = $_POST["table"];

$queryLower = strtolower($query);
$fromPos = strrpos($queryLower, "from");
$deleteQuery = "DELETE ".substr($query, $fromPos);

$queryCreate = "CREATE TABLE ".$tableName." ".$query;


?>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Archive Data</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class="row-fluid">
				<div class="span7">
					Query for data: 
					<pre><?=$query?></pre>
				</div>
				<div class="span5">
					<br/><br/>
					This is the data that will be archived...
				</div>
			</div>
			<div class="row-fluid">
				<div class="span7">
					Query for table creation: 
					<pre><?=$queryCreate?></pre>
				</div>
				<div class="span5">
					<br/><br/>
					This is the the query that will create the new table...
				</div>
			</div>
			<div class="row-fluid">
				<div class="span7">
					Query for deleting data:
					<pre><?=$deleteQuery?></pre>
				</div>
				<div class="span5">
					<br/><br/>
					All the data will be deleted from the original table afterwards.<br/>
					It's up to <b>YOU</b> to guarantee the consistence of your data and your system!
				</div>
			</div>
			<hr/>
			<div class="row-fluid"><div class="span12">
				<textarea class="textarea_large" style="height: 100px;" id="query_archive">
<?=$queryCreate?>;
<?=$deleteQuery?>
				</textarea>
			</div></div>
			<div class='row-fluid'>
				<div class='span9'>&nbsp;</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="archiveQueryRun();"><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;Run Query</button>
				</div>
			</div>
		</content>
	</div>
</div>
