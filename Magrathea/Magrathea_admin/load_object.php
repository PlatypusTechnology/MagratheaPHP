<?php

require ("admin_load.php");

$obj_name = $_POST["object"];
$obj_data = getObject($obj_name);

$relations = GetRelationsByObject($obj_name);
$javaScriptRelation = "";
$relationsProperties = "";
$relationsMethods = "";
foreach( $relations as $rel ){
	$javaScriptRelation .= "HtmlRelation('".$rel["rel_name"]."', '".$rel["rel_type_text"]."', '".$rel["rel_type"]."', '".$rel["rel_object"]."', '".$rel["rel_field"]."', '".$rel["rel_method"]."', '".$rel["rel_property"]."');";
	$returns = "";
	if($rel["rel_type"] == "belongs_to"){
		$returns = $rel["rel_object"];
	} else {	
		$returns = "array of ".$rel["rel_object"]."s";
	}
	$relationsProperties .= "<li>".$rel["rel_property"]." (".$returns.")&nbsp;<i class='fa fa-exchange' title='relational property'></i></li>";
	$relationsMethods .= "<li>".$obj_name."-&gt;".$rel["rel_method"]."();&nbsp;<i class='fa fa-exchange' title='relational method'></i><br/>Gets object related ".$returns."</li>";
}

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Objects</span><span class="breadc divider">|</span><span class="breadc active"><?=$obj_name?></span>
		</header>
		<content>
			<h3><?=$obj_name?></h3>
			<p>View this object.</p>
		</content>
	</div>
</div>

<div class="row-fluid">
<div class="span12">
	<div class="alert">
		<button class="close" data-dismiss="alert" type="button" id="warning_objexists_bt">×</button>
		<strong>WARNING! (and I mean it!)</strong><br/>
		This object already exists and it may be already in use around the system...<br/>
		Any modification should be done extremely carefully, otherwise you can fuck the whole thing and you will have a bad time...
	</div>
</div>
</div>

<div class="row-fluid"><div class="span12" id="object_result"></div></div>

<form id="form_object" onSubmit="return false;">
<input type="hidden" name="object_name" value="<?=$obj_name?>"/>
<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Object <?=$obj_name?></h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<dl class="dl-horizontal">
				<dt>Public Properties</dt>
				<dd>
					<ul>
<?
	$obj_fields = array();
	foreach($obj_data as $key => $item){
		if( substr($key, -6) == "_alias" ){
			$field_name = substr($key, 0, -6);
			if( $field_name == "created_at" || $field_name == "updated_at" ) continue;
			array_push($obj_fields, $field_name);
			echo "<li>".(empty($obj_data[$field_name."_alias"]) ? $field_name : $item)." (".$obj_data[$field_name."_type"].") ".($field_name == $obj_data["db_pk"] ? "<i class='fa fa-key' title='primary key'></i>" : "" )."</li>";
		}
	}
	echo $relationsProperties;
?>
					</ul>
				</dd>
				<dt>Protected Properties</dt>
				<dd>
					<ul>
						<li>created_at (timestamp)</li>
						<li>updated_at (timestamp)</li>
					</ul>
				</dd>
				<dt>Public Methods</dt>
				<dd><ul>
					<li><?=$obj_name?>-&gt;Insert();<br/>
						Insert the current object in the database - (create a new one).
					</li>
					<li><?=$obj_name?>-&gt;Update();<br/>
						Update this object in the database.
					</li>
					<li><?=$obj_name?>-&gt;Save();<br/>
						Save the object. - If it exists, updates it, otherwise, inserts it...
					</li>
					<li><?=$obj_name?>-&gt;Delete();<br/>
						Delete the object. - Watch out! The object gets excluded from the database!
					</li>
					<li><?=$obj_name?>-&gt;GetId();<br/>
						Gets the ID from the object.
					</li>
					<li><?=$obj_name?>-&gt;GetByID($id);<br/>
						Gets the object by the given ID.
					</li>
					<li><?=$obj_name?>-&gt;GetNextID();<br/>
						Gets the next ID from the database.
					</li>
					<?=$relationsMethods?>
				</ul></dd>
			</dl>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Details</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class='row-fluid'>
				<div class='span3'><i class='fa fa-table'></i>&nbsp;&nbsp;&nbsp;Table:</div>
				<div class='span9'>
					<?=$obj_data["table_name"]?>
				</div>
			</div>
			<div class='row-fluid'>
				<div class='span3'>Lazy Load:</div>
				<div class='span9'>
					<input type='hidden' name='lazy_load' value='false'>
					<input class='os_chbox_effect' type='checkbox' name='lazy_load' id='lazy_load' value='true' <?=($obj_data["lazy_load"]=="true" ? "checked='checked'" : "")?> >
				</div>
			</div>
			<div class='row-fluid'>
				<div class='span9'>&nbsp;</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="saveObject();"><i class="fa fa-check-circle"></i>&nbsp;Save Object</button>
				</div>
			</div>
		</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Relationships</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class="row-fluid" id="add_new_relation_button">
				<button class="btn" onClick="ShowHideNewRelation();"><i class="fa fa-plus"></i>&nbsp;Create new relation</button>
			</div>
			<div class="row-fluid" id="add_new_relation" style="display: none;">
				<ul class="nav nav-tabs">
					<li class="active"><a><i class="fa fa-plus"></i>&nbsp;Create new relation</a></li>
				</ul>
				<div class="tab-content">
					<div class="row-fluid">
						<div class="span4">
							<select id="relation_type" name="relation_type" class='input-medium'>
								<option value="belongs_to">belongs to</option>
								<option value="has_many">has many</option>
								<option value="has_and_belongs_to_many">has and belongs to many</option>
							</select>
						</div>
						<div class="span4">
							<select id="relation_object" name="relation_object" class='input-medium'>
	<?
		$objects = getAllObjects();
		foreach($objects as $obj => $obj_data){
			echo "<option value='".$obj."'>".$obj."</option>";
		}
	?>
							</select>
						</div>
						<div class="span4">&nbsp;</div>
					</div>
					<div class="row-fluid">
						<div class="span8">
						<div id="related_field">
						</div>
						</div>
						<div class="span4">
							<button class="btn btn-success" onClick="addNewRelation(); return false;"><i class="fa fa-ok"></i>&nbsp;Add Relation</button>
							<button class="btn btn-danger" onClick="ShowHideNewRelation(); return false;"><i class="fa fa-remove"></i>&nbsp;Cancel</button>
						</div>
					</div>
				</div>
			</div>
			<br/><hr/>
			<div class="row-fluid" id="object_relations">
<?
		/*
	foreach( $relations as $rel ){
		?>
<div id="<?=$rel["rel_name"]?>"><div class="row-fluid">
	<div class="span8"><?=$rel["rel_type_text"]?> 
		<input type="hidden" name="rel_type_text[]" value="<?=$rel["rel_type_text"]?>"><input type="hidden" value="<?=$rel["rel_type"]?>" name="rel_type[]">
		<i class="icon-chevron-right"></i> <?=$rel["rel_object"]?>
		<input type="hidden" value="<?=$rel["rel_object"]?>" name="rel_object[]">
		<?=($rel["rel_type"]=="belongs_to" ? '[<i class="icon-table"></i> using '.$rel["rel_field"].' field]<input type="hidden" value="'.$rel["rel_field"].'" name="rel_field[]">' : '')?>
		<?=($rel["rel_type"]=="has_many" ? '[<i class="icon-table"></i> using '.$rel["rel_object"].'\'s '.$rel["rel_field"].' field]<input type="hidden" value="'.$rel["rel_field"].'" name="rel_field[]">' : '')?>
	</div>
	<div class="span4">
		<button class="btn btn-danger" onclick="DeleteRelation('<?=$rel["rel_name"]?>'); return false;"><i class="icon-trash"></i> Delete</button>
	</div>
</div>
<div id="<?=$rel["rel_name"]?>_code" class="row-fluid">
	<div class="span5">Public Property:
		<div class="input-append"><input id="<?=$rel["rel_name"]?>_property" type="text" value="<?=$rel["rel_property"]?>" name="<?=$rel["rel_name"]?>_property">
			<button class="btn btn-danger" type="button" onclick="$(<?=$rel["rel_name"]?>_property).val('<?=($rel["rel_type"]=="belongs_to") ? $rel["rel_object"] : $rel["rel_object"]."s"?>');"><i class="icon-off"></i> (reset)</button>
		</div>
	</div>
	<div class="span5">Public Method:
		<div class="input-append"><input id="<?=$rel["rel_name"]?>_method" type="text" value="<?=$rel["rel_method"]?>" name="<?=$rel["rel_name"]?>_method">
			<button class="btn btn-danger" type="button" onclick="$(<?=$rel["rel_name"]?>_method).val('<?=($rel["rel_type"]=="belongs_to") ? "Get".$rel["rel_object"] : "Get".$rel["rel_object"]."s"?>');"><i class="icon-off"></i> (reset)</button>
		</div>
	</div>
	<div class="span2">&nbsp;</div>
</div><br><hr></div>
		<?
	}
		*/
?>
			</div>
			<div class='row-fluid'>
				<div class='span9'>&nbsp;</div>
				<div class='span3'>
					<button class="btn btn-success" onClick="saveObject();"><i class="fa fa-check-circle"></i>&nbsp;Save Object</button>
				</div>
			</div>
		</content>
	</div>
</div>
</form>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Code</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
				<?php
					$site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
					$base_dir = $site_path."/Models/Base";

					$file_name = $obj_name."Base.php";
					if( !file_exists($base_dir."/".$file_name) ){
						echo "<pre>Code is not yet created...</pre>";
					} else {
						$code = file_get_contents($base_dir."/".$file_name);
						echo "Code located at ".$base_dir."/".$file_name;
						echo "<pre class=\"prettyprint linenums\">".htmlspecialchars($code)."</pre>";
					}
				?>
		</content>
	</div>
</div>


<script type="text/javascript">
function ShowHideNewRelation(){
	$("#add_new_relation_button").slideToggle("slow");
	$("#add_new_relation").slideToggle("slow");
	loadFieldsFromObject("<?=$obj_name?>");
}

function addNewRelation(){
	var rel_type = $("#relation_type option:selected").val();
	var rel_type_val = $("#relation_type option:selected").val();
	var rel_object = $("#relation_object option:selected").val();
	var relation_name = "rel_<?=$obj_name?>_"+rel_type_val+"_"+rel_object;

	var rel_field = $("#relation_field option:selected").val();

	var property = (rel_type == "belongs_to" ? rel_object : rel_object+"s");
	var method = (rel_type == "belongs_to" ? "Get"+rel_object : "Get"+rel_object+"s");

	HtmlRelation(relation_name, rel_type, rel_type_val, rel_object, rel_field, method, property);
	ShowHideNewRelation();
}

function HtmlRelation(relation_name, rel_type, rel_type_val, rel_object, rel_field, method, property){
	
	var optionsButtons = '<div class="span4">';
	optionsButtons += '<button class="btn btn-danger" onClick="DeleteRelation(\''+relation_name+'\'); return false;"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>&nbsp;';
	optionsButtons += '</div>';
	var code_manag = '<div class="row-fluid" id="'+relation_name+'_code">';
	code_manag += '<div class="span5">Public Property:<div class="input-append"><input type="text" name="'+relation_name+'_property" id="'+relation_name+'_property" value="'+property+'"><button class="btn btn-danger" onClick="$('+relation_name+'_property).val(\''+property+'\');" type="button"><i class="fa fa-power-off"></i> (reset)</button></div></div>';
	code_manag += '<div class="span5">Public Method:<div class="input-append"><input type="text" name="'+relation_name+'_method" id="'+relation_name+'_method" value="'+method+'"><button class="btn btn-danger" onClick="$('+relation_name+'_method).val(\''+method+'\');" type="button"><i class="fa fa-power-off"></i> (reset)</button></div></div>';
	code_manag += '<div class="span2">&nbsp;</div>';
	code_manag += '</div>';

	var html_content = '<div id="'+relation_name+'">';
	html_content += '<div class="row-fluid">';
	html_content += '<div class="span8">'+rel_type+'&nbsp;<input type="hidden" name="rel_type_text[]" value="'+rel_type+'"><input type="hidden" name="rel_type[]" value="'+rel_type_val+'"><i class="fa fa-chevron-right"></i>&nbsp;'+rel_object+'<input type="hidden" name="rel_object[]" value="'+rel_object+'">';
	if( rel_type_val == "belongs_to" ){
		html_content += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i class="fa fa-table"></i> using '+rel_field+' field]<input type="hidden" name="rel_field[]" value="'+rel_field+'">';
	} else if(rel_type_val == "has_many") {
		html_content += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i class="fa fa-table"></i> using '+rel_object+'\'s '+rel_field+' field]<input type="hidden" value="'+rel_field+'" name="rel_field[]">'
	}
	html_content += '</div>';
	html_content += optionsButtons;
	html_content += '</div>';
	html_content += code_manag;
	
	html_content += '<br/><hr/></div>';

	$("#object_relations").append(html_content);

}

function DeleteRelation(rel_name){
	console.info("deleting "+rel_name);
	if( !confirm("Delete this relation? Are you sure?") ) return false;
	$.ajax({
		url: "?page=delete_relation.php",
		type: "GET",
		data: { 
			relation: rel_name
		}, 
		success: function(data){
			if( data == "<!--false-->" ){
				$.jGrowl("Some error happened when trying to delete this relation!", { header: 'Error', theme:"notification_styled_error" });	
			} else if (data == "<!--true--->") {
				$.jGrowl("Relation was deleted", { header: 'Bye bye, relation...', theme:"notification_styled_success" });			
				$("#"+rel_name).remove();
			}
		}
	});
}

function loadFieldsFromObject(obj_name){
	$.ajax({
		url: "?page=object_relation_fields.php",
		type: "POST",
		data: { 
			object: obj_name
		}, 
		success: function(data){
			$("#related_field").html(data);
			$("#related_field").fadeIn("slow");
		}
	});
}

jQuery( function($) { 
	$(".os_chbox_effect").iButton({
		labelOn: "true", labelOff: "false", easing: 'easeOutBounce', duration: 500
	});
	$("#relation_type").bind("change", function() {
		$("#relation_object").unbind("change");
		$("#related_field").hide();
		if( $(this).attr("value") == "belongs_to" ){ 
			loadFieldsFromObject("<?=$obj_name?>");
		} else {
			loadFieldsFromObject($("#relation_object option:selected").val());
			$("#relation_object").bind("change", function(){
				var selected = $(this).attr("value");
				loadFieldsFromObject(selected);
			});
		}
	});
	prettyPrint();
	<?=$javaScriptRelation?>
});
</script>


