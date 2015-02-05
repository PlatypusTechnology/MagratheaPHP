<?php

require ("admin_load.php");

$table = $_POST["table"];
$query = "SHOW columns FROM ".$table;
$columns = $magdb->queryAll($query);

//p_r($columns);

?>


<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Tables</span><span class="breadc divider">|</span><span class="breadc active"><?=$table?></span>
		</header>
		<content>
			<h3><?=$table?></h3>
			<p>Create and edit the object for this table.</p>
		</content>
	</div>
</div>


<?

$savedData = @loadConfig($table);
$objexists = false;
if( !empty($savedData) ){
	$objexists = true;
	?>
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
	<?
}

?>

<div class="row-fluid"><div class="span12" id="object_result"></div></div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Table</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
<?
	$pk = "";
	$inputFields = array();
	foreach($columns as $cl){
		if( $cl["key"] == "PRI" ) $pk = $cl["field"];
		array_push($inputFields, $cl["field"]);
		echo "<div class='row-fluid'><div class='span4 right'>".$cl["field"]."</div><div class='span8'>(".$cl["type"].")</div></div>";
	}
	$isTableReady = ( array_search("created_at", $inputFields) != FALSE && array_search("updated_at", $inputFields) != FALSE );
	
?>
				<hr/>
				<div class='row-fluid'>
					<div class='span4 right'><i class="fa fa-key"></i>&nbsp;&nbsp;Id Key:</div>
					<div class='span8'>
						<?=$pk?>
						<!--select>
							<? magrathea_printFields($inputFields, $pk); ?>
						</select-->
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span12 center'>
						<?= $isTableReady ? "&nbsp;" : "<button class='btn' onClick='createFieldInTable(\"".$table."\");'>Create \"created_at\" and \"updated_at\" field</button>" ?>&nbsp;&nbsp;&nbsp;
					</div>
				</div>
			</content>
	</div>
</div>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
				<h3>Object</h3>
				<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
<?	
	if( $isTableReady ){
		?>
			<form id="form_object">
			<input type="hidden" name="table_name" id="table_name" value="<?=$table?>" />
			<input type="hidden" name="obj_exists" id="obj_exists" value="<?=$objexists?>" />
			<input type="hidden" name="db_pk" id="db_pk" value="<?=$pk?>" />
			<div class='row-fluid'>
				<div class='span12'>
					<label>Object Name: <input type="text" name="object_name" id="object_name" class="default" value="<?=@($objexists ? $savedData["obj_name"] : "" )?>" /></label>
				</div>
			</div>
			<div class='row-fluid'>
				<div class='span12 center'>
				<table class="table table-striped">
					<tbody>
						<thead>
							<th>Field</th>
							<th>Type</th>
							<th>Alias</th>
						</thead>
						<?
				$even = false;
				foreach($columns as $cl){
					$selectedType = ($objexists && !empty($savedData[$cl["field"]."_type"])) ? $savedData[$cl["field"]."_type"] : getSelectedField($cl["type"]);
					?>
					<tr <?=($even ? "class='even'" : "")?>>
						<td><input type="hidden" name="fields[]" id="field_<?=$cl["field"]?>" value="<?=$cl["field"]?>"><?=$cl["field"]?></td>
						<td><?=buildTypesSelect($cl["field"],$selectedType)?></td>
						<td><input type="text" name="alias_<?=$cl["field"]?>" id="alias_<?=$cl["field"]?>" class="default input-medium" value="<?=@($objexists ? $savedData[$cl["field"]."_alias"] : "" )?>" /></td>
					</tr>
					<?
					$even = !$even;
				}
						?>
					</tbody>
				</table>
				</form>
				</div>
			</div>
			<div class='row-fluid'>
				<div class='span8'></div>
				<div class='span4 center'>
					<label><button class='btn' onClick='createObject();'><?=($objexists ? "Update" : "Create" )?> object</button></label>
				</div>
			</div>
		<div class="dataTables_wrapper" role="grid">
			<div class="dataTables_length center">
			</div>
			<div id="example_filter" class="dataTables_filter">
			</div>
		</div>
		<?
	} else {
		echo "<section class='welly form_align'>Table is not ready to be an object yet...</section>";
	}
?>
		</content>
	</div>
</div>



<?

function loadConfig($table){
	return getObjectByTable($table);
}


function buildTypesSelect($fieldName, $selected){

	if( $fieldName == "created_at" || $fieldName == "updated_at" ) 
		return "<input type='hidden' id='type_".$fieldName."' name='type_".$fieldName."' value='timestamp' />timestamp";

	$types = magrathea_getTypesArr();
	$objects = getAllObjects(true);

	$select = "<select id='type_".$fieldName."' name='type_".$fieldName."' class='input-medium'>";
	foreach($types as $t){
		$select .= "<option name='".$t."' ".($t == $selected ? "selected" : "").">".$t."</option>";
	}
	/*
	$select .= "<option disabled='disabled'>----</option>";
	foreach( $objects as $obj ){
		$select .= "<option name='".$obj."' ".($obj == $selected ? "selected" : "").">".$obj."</option>";
	}
	*/
	$select .= "</select>";
	return $select;
}

function getSelectedField($fieldType){
	$currentType = "";
	$stype = substr($fieldType, 0, 3);
	switch($stype){
		case "int":
			$currentType = "int";
		break;
		case "var":
			$currentType = "string";
		break;
		case "tex":
			$currentType = "text";
		break;
		case "tim":
		case "dat":
			$currentType = "datetime";
		break;
		case "flo":
			$currentType = "float";
		break;
		default:
		break;
	}
	return $currentType;
}


?>

