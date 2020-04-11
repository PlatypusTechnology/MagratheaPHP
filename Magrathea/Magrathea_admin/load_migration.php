<?php

require ("admin_load.php");
$config = MagratheaConfig::Instance()->GetConfig();

?>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Database</span>
		</header>
		<content>
			<p>Manage and update database migrations.</p>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Backup <i class="fa fa-cloud-download"></i></h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class="row-fluid">
				<div class="span6 center">
					<button class="btn btn-success" onClick="backup();"><i class="fa fa-eye"></i> <i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;...View saved backup...</button>
				</div>
				<div class="span6 center">
					<button class="btn btn-success" onClick="backup();"><i class="fa fa-save"></i> <i class="fa fa-database"></i> <i class="fa fa-arrow-down"></i>&nbsp;&nbsp;&nbsp;...Create Backup...</button>
				</div>
			</div>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Query</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class="row-fluid"><div class="span12">
				<textarea class="textarea_large" id="query_run">SELECT TABLE_NAME FROM information_schema.tables ORDER BY TABLE_NAME</textarea>
			</div></div>
			<div class='row-fluid'>
				<div class='span9'>&nbsp;</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="queryRun();"><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;Run Query</button>
				</div>
			</div>
			<br/>
		</content>
	</div>
</div>

<div id="database_result"></div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Available Objects</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<?php
			$objects = getAllObjects();
			if(is_array($objects)){
				$even = false;
				foreach($objects as $obj => $details){
					?>
					<div class="singlePlugin <?=($even ? "even" : "odd")?>">
						<div class='row-fluid' style="padding-top: 5px;">
							<div class="span6" style="padding-left: 20px;"><?=$obj?></div>
							<div class="span6 right" style="padding-right: 20px;">
								<button class="btn btn-default" onClick="objectDetail('<?=$obj?>', this);"><i class="fa fa-book"></i> <i class="fa fa-terminal"></i>&nbsp;Create object query</button>
							</div>
						</div>
					</div>
					<?php
				}
				$even = !$even;
			}
			?>
		</content>
	</div>
</div>


<script type="text/javascript">
function objectDetail(obj, element){
	responseIn = $("#query_run");
	$(responseIn).html("Loading...");
	$.ajax({
		url: "?magpage=object_query.php",
		type: "POST",
		data: { 
			object: obj
		}, 
		success: function(data){
			$(responseIn).html(data);
			scrollToTop();
		}
	});
}

function queryRun(){
	var code = $("#query_run").val();
	var responseDiv = $("#database_result");
	$.ajax({
		url: "?magpage=database_run.php",
		type: "POST",
		data: { 
			sql: code
		}, 
		success: function(data){
			responseDiv.html(data);
		}
	});
}

function backup(){
	history.replaceState({}, "Magrathea Admin - Backups", "<?=@$basename?>?area=migration");
	$.ajax({
		url: "?magpage=load_backup.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Backups");
			scrollToTop();
		}
	});
}

</script>






