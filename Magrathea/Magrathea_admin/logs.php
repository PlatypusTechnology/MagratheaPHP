<?php

require ("admin_load.php");


?>
<html>

<head>
<title><?=$_GET['file']?> - Magrathea Logs</title>
<?=MagratheaView::Instance()->InlineCSS()?>
<style>
#logResult {
	height: 600px;
	overflow: scroll;
	padding: 5px;
	border: 1px solid #CCC;
	font-family: monospace;
	font-size: 12px;
	color: green;
	background-color: black;
}
.small {
	width: 40px;
}</style>
</head>

<body>
	<div class="container">
		<br/><br/>
	<div class='row-fluid'>
		<div class='span4'>
			Lines to show:
			<input type="text" class="small" id="lines" value="<?=$_GET['lines']?>" />
		</div>
		<div class="span4">
			Refresh Rate:
			<input type="text" class="small" id="seconds" value="1" />
			(seconds)
		</div>
		<div class="span4">&nbsp;</div>
	</div>
	<div class='row-fluid'>
		<div class="span12" id="logResult"></div>
	</div>
	</div>
</body>


<?=MagratheaView::Instance()->InlineJavascript()?>
<script type="text/javascript">
var logName = "<?=$_GET['file']?>";

function openLog(l){
	logName = l;
	$("#logName").html(logName);
	tail();
}

function loadTail(){
	seconds = parseFloat($("#seconds").val());
	if(seconds == 0) seconds = 2;
	window.setTimeout(tail, seconds*1000);	
}

function tail(){
	var lines = parseInt($("#lines").val());
	if(lines == 0) lines = 50;

	$.ajax({
		url: "?page=log_tail.php&file="+logName+"&lines="+lines,
		type: "POST",
		success: function(data){
			$("#logResult").slideDown("slow");
			$("#logResult").html(data);
			loadTail();
		}
	});
}

tail();

</script>

</html>