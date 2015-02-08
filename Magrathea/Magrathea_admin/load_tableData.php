<?php

require ("admin_load.php");

$table = $_POST["table"];


$query = MagratheaQuery::Select()->Table($table)->Limit(50);

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Tables</span><span class="breadc divider">|</span><span class="breadc active"><?=$table?></span>
		</header>
		<content>
			<h3><?=$table?></h3>
			<p>Data from table....</p>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Query Builder</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content style="display: none;">
			<div class="row-fluid"><div class="span12">
				<textarea class="textarea_large" style="height: 100px;" id="query_build">
MagratheaQuery::Select()
	->Table("<?=$table?>")
	->Limit(50)
	->Order("id ASC")
	->SQL();
				</textarea>
			</div></div>
			<div class='row-fluid'>
				<div class='span9'>
					<a href="http://magrathea.platypusweb.com.br/class-MagratheaQuery.html.php" target="_blank">
						MagratheaQuery Documentation <i class="fa fa-external-link"></i>
					</a>
				</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="queryBuilder();"><i class="fa fa-arrow-right"></i><i class="fa fa-code"></i>&nbsp;Build Query</button>
				</div>
			</div>

		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Table</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class="row-fluid"><div class="span12">
				<textarea class="textarea_large" style="height: 100px;" id="query_run"><?=$query->SQL()?></textarea>
			</div></div>
			<div class='row-fluid'>
				<div class='span9'>&nbsp;</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="queryRun();"><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;Run Query</button>
				</div>
			</div>

		</content>
	</div>
</div>


<div id="database_result"></div>


<script type="text/javascript">
var responseDiv = null;

function queryBuilder(){
	var code = $("#query_build").val();
	responseHere = $("#query_run");
	$.ajax({
		url: "?page=query_builder.php",
		type: "POST",
		data: { 
			exec: code
		}, 
		success: function(data){
			responseHere.val(data);
		}
	});
}

function queryRun(){
	var code = $("#query_run").val();
	responseDiv = $("#database_result");
	$.ajax({
		url: "?page=database_run.php",
		type: "POST",
		data: { 
			sql: code
		}, 
		success: function(data){
			responseDiv.html(data);
		}
	});
}

</script>







