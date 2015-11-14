<?php

require ("admin_load.php");

function loadPluginsList($installed=false){
	if($installed) {
		$plugins_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path").'/plugins/';
	} else {
		$plugins_path = MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path").'/plugins/';
	}
	if(!is_dir($plugins_path)){
		echo '<div class="alert alert-error"><strong>Directory doesn\'t exists!</strong><br/>Directory: <br/>[<b>'.$plugins_path.'</b>]<br/> does not exists. Create it with write permissions, please...</div>';
		return;
	}
	$results = scandir($plugins_path);
	$plugins = array();
	foreach ($results as $result) {
	    if ($result === '.' or $result === '..') continue;
	    if (is_dir($plugins_path.'/'.$result)) {
	        array_push($plugins, $result);
	    }
	}
	return $plugins;
}

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Plugins</span>
		</header>
		<content>
			<p>A lot of plugins to develop apps in a easier way!</p>
		</content>
	</div>
</div>


<div class="row-fluid">
<div class="span12" id="install_response">
	<div class="alert alert-info">
		<button class="close" data-dismiss="alert" type="button" id="warning_objexists_bt">×</button>
		<strong>Remember, remember...</strong><br/><del>the fifth of November.</del><br/>
		Watch out removing plugins that are already in use!
	</div>
</div>
</div>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Available Plugins</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<?php
			$plugins = loadPluginsList();
			$even = false;
			$line_number = 1;
			foreach($plugins as $p){
				?>
				<div class="singlePlugin <?=($even ? "even" : "odd")?>">
					<div class='row-fluid' style="padding-top: 5px;">
						<div class="span9" style="padding-left: 20px;"><?=$p?></div>
						<div class="span3 right" style="padding-right: 20px;">
							<button class="btn btn-default" onClick="pluginDetail('<?=$p?>', this);"><i class="fa fa-eye"></i>&nbsp;View details</button>
						</div>
					</div>
					<div class='row-fluid plugin_extras' style="padding-left: 10px; display: none;">
						<div class="span9 plugin_details"></div>
						<div class="span3 plugin_install">
							<button class="btn btn-default" onClick="installPlugin('<?=$p?>');"><i class="fa fa-download"></i>&nbsp;Install Plugin!</button>
						</div>
					</div>
				</div>
				<?php
				$even = !$even;
			}
			?>
		</content>
	</div>
</div>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3>Installed Plugins</h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<?php
			$plugins = loadPluginsList(true);
			if($plugins){
				$even = false;
				$line_number = 1;
				foreach($plugins as $p){
					?>
					<div class='row-fluid <?=($even ? "even" : "")?>' style="padding: 5px;">
						<div class="span9" style="padding-left: 20px;"><?=$p?></div>
						<div class="span3 right" style="padding-right: 20px;">
							<button class="btn btn-default" onClick="removePlugin('<?=$p?>');"><i class="fa fa-trash-o"></i>&nbsp;Unninstal</button>
						</div>
					</div>
					<?php
					$even = !$even;
				}
			}
			?>
		</content>
	</div>
</div>

<script type="text/javascript">
function pluginDetail(pluginFolder, element){
	$(element).parent().hide("slow");
	var parent = $(element).parent().parent().parent();
	parent.find(".plugin_extras").show("slow");
	var responseDiv = $(parent).find(".plugin_details");
	$(responseDiv).html("Loading...");
	$.ajax({
		url: "?magpage=plugin_details.php",
		type: "POST",
		data: { 
			folder: "Magrathea",
			plugin_folder: pluginFolder
		}, 
		success: function(data){
			$(responseDiv).html(data);
		}
	});
}

function installPlugin(pluginFolder){
	$.ajax({
		url: "?magpage=plugin_install.php",
		type: "POST",
		data: { 
			plugin_folder: pluginFolder,
			action: "install"
		}, 
		success: function(data){
			if(data.trim() == ""){
				loadPlugins();
				scrollToTop();
			} else {
				$("#install_response").html(data);
				scrollToTop();
			}
		}
	});
}

function pluginQueryRun(pluginFolder){
	var code = $("#"+pluginFolder+"_query").val();
	$.ajax({
		url: "?magpage=database_run.php",
		type: "POST",
		data: { 
			sql: code
		}, 
		success: function(data){
			$("#install_response").html(data);
			scrollToTop();
		}
	});
}

function removePlugin(pluginFolder){
	$.ajax({
		url: "?magpage=plugin_install.php",
		type: "POST",
		data: { 
			plugin_folder: pluginFolder,
			action: "remove"
		}, 
		success: function(data){
			loadPlugins();
			scrollToTop();
		}
	});
}
</script>





