<?php

require ("admin_load.php");

$config = MagratheaConfig::Instance()->GetConfig();

function loadLogs(){
	$logsPath = MagratheaConfig::Instance()->GetConfigFromDefault("site_path").'/../logs';
	if(!is_dir($logsPath)){
		echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>'.$logsPath.'</b>]<br/> does not exists. Create it with write permissions, please...</div>';
		return;
	}
	$results = scandir($logsPath);
	$logs = array();
	foreach ($results as $result) {
	    if ($result === '.' or $result === '..') continue;
		array_push($logs, $result);
	}
	sort($logs);
	return array_reverse($logs);
}

?>

<style>
#logResult {
  height: 400px;
  overflow: scroll;
  padding: 5px;
  border: 1px solid #CCC;
  font-family: monospace;
  font-size: 12px;
  color: green;
  background-color: black;
}
.small {
	width: 20px;
}
</style>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Logs</span>
		</header>
		<content>
			<p>System Logs.</p>
		</content>
	</div>
</div>

<div class="row-fluid" id="logSection" style="display: none;">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3 id="logName">Log</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class='row-fluid'>
				<div class='span4'>
					Lines to show:
					<input type="text" class="small" id="lines" value="25" />
				</div>
				<div class="span4">
					Refresh Rate:
					<input type="text" class="small" id="seconds" value="2" />
					(seconds)
				</div>
				<div class="span4">
					<button class="btn" onClick="externalize()">
						<i class="fa fa-external-link"></i>
						View in new window
					</button>
				</div>
			</div>
			<div class='row-fluid'>
				<div class="span12" id="logResult"></div>
			</div>
		</content>
	</div>
</div>

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
			$logs = loadLogs();
			$even = false;
			foreach($logs as $l){
				?>
				<tr <?=($even ? "class='even'" : "")?>>
					<td style="padding-left: 50px;">
						<a href="javascript: openLog('<?=$l?>')"><?=$l?></a>
					</td>
					<td>
						<button onClick="removeFile('<?=$l?>');" class="btn">
							<i class="fa fa-trash-o"></i> Remove file
						</button>
						<button onClick="externalize('<?=$l?>');" class="btn">
							<i class="fa fa-external-link"></i> View in new window
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
var logName = "";

function openLog(l){
	logName = l;
	$("#logName").html(logName);
	tail();
}

function removeFile(l){
	$.ajax({
		url: "?magpage=log_remove.php&file="+l,
		success: function(data){
			loadLogs();
		}
	});

}

function loadTail(){
	seconds = parseInt($("#seconds").val());
	if(seconds == 0) seconds = 2;
	window.setTimeout(tail, seconds*1000);	
}

function tail(){
	var lines = parseInt($("#lines").val());
	if(lines == 0) lines = 50;

	$.ajax({
		url: "?magpage=log_tail.php&file="+logName+"&lines="+lines,
		type: "POST",
		success: function(data){
			$("#logSection").slideDown("slow");
			$("#logResult").html(data);
			loadTail();
		}
	});
}

function externalize(file){
	if(!file) file = logName;
	var lines = parseInt($("#lines").val());
	if(lines == 0) lines = 50;
	window.open("?magpage=logs.php&file="+file+"&lines="+lines, "MagratheaLogs");
}
</script>
