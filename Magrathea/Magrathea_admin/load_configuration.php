<?php

require ("admin_load.php");

$config = MagratheaConfig::Instance()->GetConfig();
$environment = MagratheaConfig::Instance()->GetEnvironment();

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Configuration</span>
		</header>
		<content>
			<p>General configuration for the site.</p>
		</content>
	</div>
</div>

<div class="row-fluid"><div class="span12" id="config_result"></div></div>

<form name="general_config" id="general_config" onSubmit="return false;">
<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>General Configuration</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa-chevron-down"></i></a></span>
		</header>
		<content>
<?
	foreach($config["general"] as $key => $value){
		echo "<div class='row-fluid'><div class='span3 right'>".$key."</div><div class='span9'>";
		if( $key == "use_environment" ){
			echo "<select name='use_environment' id='use_environment' onChange='loadConfigSection();'>";
			foreach($config as $area => $items){
				if( $area == "general" ) continue;
				echo "<option value='".$area."' ".($area==$environment ? "selected" : "").">".$area."</option>";
			}
			echo "</select>";
//			echo "<span class='help-block'>\"use_environment\" is Deprecated...<br/> but here you can choose the environment that will be used...</span>";
		} else if( $value == "true" || $value == "false" ){
			echo "<input type='hidden' name='".$key."' value='false'>"; // don't worry... if the value is true, this will be overwritten...
			echo "<input class='ibutton' type='checkbox' name='".$key."' id='".$key."' value='true' ".($value=="true" ? "checked='checked'" : "")." />";
		} else {
			echo "<input type='text' name='".$key."' id='".$key."' value='".$value."'>";
		}
		echo "</div></div>";
	}
?>
				<div class='row-fluid'>
					<div class='span12 center'>
						<button class='btn btn-success' onClick='saveConfig(false);'><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Save Configuration</button>
					</div>
				</div>
			</content>
		</div>
	</div>
</div>
</form>


<div id="LoadConfigSection">
	<?
	include("load_configuration_section.php");
	?>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Database testing</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class='row-fluid'>
				<div class='span6 center'>
					<button class='btn' onClick='testConnection();'><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;&nbsp;Test Connection</button><br/>
				</div>
				<div class="span6" id="database_result">
				</div>
			</div>
		</content>
	</div>
</div>

<script type="text/javascript">
function testConnection(){
	var conn = {
		host: $("input#db_host").val(),
		user: $("input#db_user").val(),
		pass: $("input#db_pass").val(),
		name: $("input#db_name").val()
	};
	$.ajax({
			url: "?magpage=database_test.php",
			type: "POST",
			data: conn, 
			success: function(data){
				$("#database_result").html(data);
			}
		});
}
</script>