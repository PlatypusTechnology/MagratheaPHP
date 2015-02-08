<?
	if(!empty($_GET["section"])){
		$environment = $_GET["section"];
	}
	if(empty($config))
		$config = MagratheaConfig::Instance()->GetConfig();

?>

<form name="specific_config" id="specific_config" onSubmit="return false;">
<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3><?=$environment?> Configuration</h3>
				<input type="hidden" name="magrathea_use_environment" id="magrathea_use_environment" value="<?=$environment?>" />
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
<?
	foreach($config[$environment] as $key => $value){
		echo "<div class='row-fluid'><div class='span3 right'>".$key."</div><div class='span9'>";
		if( $value == "true" || $value == "false" ){
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
						<button class='btn btn-success' onClick='saveConfig(true);'><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Save Configuration</button>
					</div>
				</div>
			</content>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
jQuery( function($) { 
	$(".ibutton").iButton({
		labelOn: "true", labelOff: "false", easing: 'easeOutBounce', duration: 500
	});
});
</script>