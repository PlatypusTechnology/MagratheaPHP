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
	$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
	$mconfig->setFile("/../configs/magrathea_objects.conf");
	$objdata = $mconfig->getConfig();
	$objdata["relations"] = $relations;
	$mconfig->setConfig($objdata);
	if( !$mconfig->saveFile(true) ){ 
		die("<!--false-->");
	}
	
	die("<!--true--->");


function DeleteRelation(&$arr_relation, $relation_name, $is_mirror = false){
	echo "deleting ".$relation_name."<br/>";
	$index = 0;
	$rel_index = -1;
	foreach( $arr_relation["rel_name"] as $rel ){
		if($rel == $relation_name){
			$rel_index = $index;
		}
		$index++;
	}
	if( $rel_index >= 0 ){
		$type = $arr_relation["rel_type"][$rel_index];
		$obj = $arr_relation["rel_object"][$rel_index];
		$base_obj = $arr_relation["rel_obj_base"][$rel_index];
		unset($arr_relation["rel_name"][$rel_index]);
		unset($arr_relation["rel_obj_base"][$rel_index]);
		unset($arr_relation["rel_type"][$rel_index]);
		unset($arr_relation["rel_type_text"][$rel_index]);
		unset($arr_relation["rel_object"][$rel_index]);
		unset($arr_relation["rel_field"][$rel_index]);
		unset($arr_relation["rel_property"][$rel_index]);
		unset($arr_relation["rel_method"][$rel_index]);
		if( !$is_mirror ){
			switch($type){
				case "belongs_to":
					$mirror_type = "has_many";
				break;
				case "has_many":
					$mirror_type = "belongs_to";
				break;
				default:
					$mirror_type = $type;
				break;
			}
			$mirror_obj = $base_obj;
			$mirror_base_obj = $obj;
			$mirror_name = "rel_".$mirror_base_obj."_".$mirror_type."_".$mirror_obj;
			return DeleteRelation($arr_relation, $mirror_name);
		}
	} else {
		return true;
	}
}

?>
