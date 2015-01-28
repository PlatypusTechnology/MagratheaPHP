<?php

require ("admin_load.php");

$config = MagratheaConfig::Instance()->GetConfig();

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Migrations</span>
		</header>
		<content>
			<p>Manage and update database migrations.</p>
		</content>
	</div>
</div>

<div class="row-fluid"><div class="span12" id="database_result"></div></div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Available Objects</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<?
			$objects = getAllObjects();
			if(is_array($objects)){
				$even = false;
				foreach($objects as $obj => $details){
					?>
					<div class="singlePlugin">
						<div class='row-fluid <?=($even ? "even" : "")?>' style="padding-top: 5px;">
							<div class="span9" style="padding-left: 20px;"><?=$obj?></div>
							<div class="span3 right" style="padding-right: 20px;">
								<button class="btn btn-default" onClick="databaseDetail('<?=$obj?>', this);"><i class="fa fa-eye"></i>&nbsp;View details</button>
							</div>
						</div>
						<div class='row-fluid <?=($even ? "even" : "")?> plugin_extras' style="padding-left: 10px; display: none;">
							<div class="span12 obj_details"></div>
						</div>
					</div>
					<?
				}
				$even = !$even;
			}
			?>
		</content>
	</div>
</div>


<script type="text/javascript">
var responseDiv = null;

function databaseDetail(obj, element){
	$(element).parent().hide("slow");
	var parent = $(element).parent().parent().parent();
	parent.find(".plugin_extras").show("slow");
	responseDiv = $(parent).find(".obj_details");
	$(responseDiv).html("Loading...");
	$.ajax({
		url: "?page=database_table.php",
		type: "POST",
		data: { 
			object: obj
		}, 
		success: function(data){
			$(responseDiv).html(data);
		}
	});
}

function databaseRun(object_run){
	var code = $("#"+object_run+"_query").val();
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






