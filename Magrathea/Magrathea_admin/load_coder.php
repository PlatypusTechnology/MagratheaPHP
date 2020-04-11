<?php

require ("admin_load.php");

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Coder</span>
		</header>
		<content>
			<p>Generate codes for all objects.</p>
		</content>
	</div>
</div>


<div class="row-fluid">
<div class="span12">
	<div class="alert alert-info">
		<button class="close" data-dismiss="alert" type="button" id="warning_objexists_bt">×</button>
		<strong>Remember, remember...</strong><br/><del>the fifth of November.</del><br/>
		Don't touch the files in the "/Models/Base" folder... They are the base for every object!
	</div>
</div>
</div>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header><h3>Generate Code</h3>
		</header>
		<content>
			<div class='row-fluid'>
					<?php
					$site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
					if(file_exists($site_path."/../configs/magrathea_objects.conf")){
					?>
				<div class='span3'>
						<button class="btn btn-success" onClick="generateCode();"><i class="fa fa-pencil"></i>&nbsp;Generate Code</button>
				</div>
				<div class='span9'>&nbsp;</div>
					<?php
					} else {
						echo "<div class='span12'>Object file config does not exist yet. Create the objects first! ;D</div>";
					}
					?>
			</div>
			<div class='row-fluid'>
				<div class='span12' id="code_result">
				</div>
			</div>
		</content>
	</div>
</div>

<script type="text/javascript">
function generateCode(){
	$.ajax({
		url: "?magpage=generate_code.php",
		success: function(data){
			$("#code_result").html(data);
		}
	});
}
</script>