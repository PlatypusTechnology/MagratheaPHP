<?php

require ("admin_load.php");
$config = MagratheaConfig::Instance();

$backupName = $config->GetFromDefault("db_name")."_".date("Ym");

?>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Backup</span>
		</header>
		<content>
			<div class="row-fluid">
				<div class="span6 center">
					<br/>
					<button class="btn btn-success" onClick="viewBackups();"><i class="fa fa-eye"></i> <i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;View saved backups</button>
				</div>
				<div class="span6 center">
					<button class="btn btn-success" onClick="createBackup();"><i class="fa fa-save"></i> <i class="fa fa-database"></i> <i class="fa fa-arrow-down"></i>&nbsp;&nbsp;&nbsp;Create Backup</button>
					<br/><br/>
					<input type="text" id="backupName" value="<?=$backupName?>" />
				</div>
			</div>
		</content>
	</div>
</div>

<div id="database_result"></div>

<script type="text/javascript">
var responseDiv = null;

function viewBackups(){
	responseDiv = $("#database_result");
	$(responseDiv).html("Loading...");
	$.ajax({
		url: "?magpage=load_backup_files.php",
		type: "GET",
		success: function(data){
			$(responseDiv).html(data);
		}
	});
}

function createBackup(){
	responseDiv = $("#database_result");
	$(responseDiv).html("Loading...");
	var fileName = $("#backupName").val();
	$.ajax({
		url: "?magpage=load_backup_save.php",
		type: "POST",
		data: { 
			name: fileName
		}, 
		success: function(data){
			$(responseDiv).html(data);
		}
	});
}

</script>






