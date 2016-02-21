<?php

	$file = @$_POST["file"];
	$action = @$_POST["action"];

	switch ($action) {
		case 'delete':
			$output = shell_exec("rm ".$file);
			echo '<div class="alert alert-success"><strong>File deleted!</strong><br/>File: [<b>'.$file.'</b>] successfully removed!</div>';
			die;
			break;
		case 'save':
			$code = $_POST["code"];
			$file_handler = fopen($file, 'w');
			fwrite($file_handler, $code);
			fclose($file_handler);
			$code = file_get_contents($file);
			break;
		default:
			$code = file_get_contents($file);
			break;
	}

?>

<style>
.editor {
	width: 90%;
	height: 300px;
}
</style>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Editor</span>
		</header>
		<content>
			<p>You are editing a Magrathea File</p>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3><?=$file?></h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<textarea class="editor" id="txt_code"><?=$code?></textarea>
			<br/>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">&nbsp;</div>
	<div class="span3">
		<button class="btn btn-success" onclick="saveFile();">
			<i class="fa fa-check"></i> Save
		</button>
	</div>
	<div class="span3">
		<button class="btn btn-danger" onclick="deleteFile();">
			<i class="fa fa-trash-o"></i> Delete
		</button>
		
	</div>
</div>


<script type="text/javascript">
function saveFile(){
	var file = "<?=$file?>";
	var content = $("#txt_code").val();
	$.ajax({
		url: "?magpage=editor.php",
		type: "POST",
		data: {
			file: file,
			action: "save",
			code: content
		},
		success: function(data){
			$("#main_content").html(data);
			scrollToTop();
		}
	});
}

function deleteFile(){
	var file = "<?=$file?>";
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





