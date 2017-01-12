<?php

	require ("admin_load.php");

	$backupFolder = realpath($site_path."/../database/backups");

	if(!is_dir($backupFolder)){
		echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>.../database/backups</b>]<br/> does not exists. Create it with write permissions, please...</div>';
		die;
	}

	$results = scandir($backupFolder);
	p_r($results)
	$backups = array();
	foreach ($results as $result) {
		if ($result === '.' or $result === '..') continue;
		array_push($backups, $result);
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
						<a href="<?=$backupFolder."/".$b?>" download class="btn">
							<i class="fa fa-download"></i> Download file
						</a>
						<button onClick="viewCode('<?=$s?>');" class="btn">
							<i class="fa fa-code"></i> View Code
						</button>
						<button onClick="removeFile('<?=$s?>');" class="btn">
							<i class="fa fa-trash-o"></i> Remove file
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
function download() {

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
