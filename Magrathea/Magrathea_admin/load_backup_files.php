<?php

	require ("admin_load.php");
	$config = MagratheaConfig::Instance();

	$site_path = $config->GetFromDefault("site_path");

	$backupFolder = realpath($site_path."/../database/backups");

	if(!is_dir($backupFolder)){
		echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>.../database/backups</b>]<br/> does not exists. Create it with write permissions, please...</div>';
		die;
	}

	$results = scandir($backupFolder);
	$backups = array();
	$size = array();
	$datec = array();
	foreach ($results as $file) {
		if ($file === '.' or $file === '..') continue;
		array_push($backups, $file);
		$size[$file] = filesize($backupFolder."/".$file);
		$datec[$file] = filectime($backupFolder."/".$file);
	}
	sort($backups);

?>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Files</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class='row-fluid'>
				<div class='span12 center'>
				<table class="table table-striped"><tbody>
			<?php
			$even = false;
			foreach($backups as $b){
				?>
				<tr <?=($even ? "class='even'" : "")?>>
					<td style="padding-left: 50px;">
						<a href="javascript: viewCode('<?=$b?>')"><?=$b?></a>
					</td>
					<td>
						<?=number_format($size[$b] / 1048576, 2) . ' MB'?>
					</td>
					<td>
						<?=date("Y-m-d h:i:s", $datec[$b])?>
					</td>
					<td>
						<button onclick="downloadCode('<?=$b?>');" class="btn">
							<i class="fa fa-download"></i> Download
						</button>
						<button onClick="viewCode('<?=$b?>');" class="btn">
							<i class="fa fa-code"></i> View
						</button>
						<button onClick="removeFile('<?=$b?>');" class="btn">
							<i class="fa fa-trash-o"></i> Remove
						</button>
					</td>
				</tr>
				<?php
				$even = !$even;
			}
			?>
				</tbody></table>
				</div>
			</div>
		</content>
	</div>
</div>

<script type="text/javascript">

function downloadCode(file) {
	window.location.href = "?magpage=backup_download.php&db_file=" + file;	
}

function viewCode(file){
	var file = "<?=$backupFolder?>/" + file;
	$.ajax({
		url: "?magpage=editor.php",
		type: "POST",
		data: {
			file: file
		},
		success: function(data){
			$("#main_content").html(data);
			scrollToTop();
		}
	});
}

function removeFile(file){
	var file = "<?=$backupFolder?>/" + file;
	$.ajax({
		url: "?magpage=editor.php",
		type: "POST",
		data: {
			file: file,
			action: "delete"
		},
		success: function(data){
			$("#main_content").html(data);
			scrollToTop();
		}
	});
}
</script>
