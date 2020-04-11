<?php

require ("admin_load.php");

	$relation_name = $_GET["relation"];
	$relations = GetRelations();

	if( count($relations["rel_name"]) > 2 ){
		if( !DeleteRelation($relations, $relation_name) ){
			die("<!--false-->");
		}
	} else {
		$relations = array();
	}

	$mconfig = new MagratheaConfigFile();
	$mconfig->setPath(realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs"));
	$mconfig->setFile("magrathea_objects.conf");
	$objdata = $mconfig->getConfig();
	$objdata["relations"] = $relations;
	$mconfig->setConfig($objdata);
	if( !$mconfig->Save(true) ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... error deleting object!</strong><br/>
			Something really strange happened. Sorry about that.
		</div>
		<?php
	}
	?>
	<!--true-->
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<strong>Breakups are never easy</strong><br/>
		But it was the best for all...
	</div>
	<?php
	die;


function DeleteRelation(&$arr_relation, $relation_name, $is_mirror = false){
	$index = 0;
	$rel_index = -1;
	foreach( $arr_relation["rel_name"] as $rel ){
		if($rel == $relation_name){
			$rel_index = $index;
		}
		$index++;
	}
	if( $rel_index >= 0 ){
		$type = @$arr_relation["rel_type"][$rel_index];
		$obj = @$arr_relation["rel_object"][$rel_index];
		$base_obj = @$arr_relation["rel_obj_base"][$rel_index];
		$field = @$arr_relation["rel_field"][$rel_index];
		unset($arr_relation["rel_name"][$rel_index]);
		unset($arr_relation["rel_obj_base"][$rel_index]);
		unset($arr_relation["rel_type"][$rel_index]);
		unset($arr_relation["rel_type_text"][$rel_index]);
		unset($arr_relation["rel_object"][$rel_index]);
		unset($arr_relation["rel_field"][$rel_index]);
		unset($arr_relation["rel_property"][$rel_index]);
		unset($arr_relation["rel_method"][$rel_index]);
		if( !$is_mirror ){
			$mirror_obj = $base_obj;
			$mirror_base_obj = $obj;
			switch($type){
				case "belongs_to":
					$mirror_type = "has_many";
					$mirror_name = "rel_".$mirror_base_obj."_".$mirror_type."_".$mirror_obj."+".$field;
				break;
				case "has_many":
					$mirror_type = "belongs_to";
					$mirror_name = "rel_".$mirror_base_obj."+".$field."_".$mirror_type."_".$mirror_obj;
				break;
				default:
					$mirror_type = $type;
					$mirror_name = "rel_".$mirror_base_obj."+".$field."_".$mirror_type."_".$mirror_obj;
				break;
			}
			return DeleteRelation($arr_relation, $mirror_name);
		}
	} else {
		return true;
	}
}

?>
