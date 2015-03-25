<?php

// load tables:
function getAllTables($db, $allTables=true){
	$magdb = MagratheaDatabase::Instance();
	try	{
		if($allTables)
			$sql = "SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA = '".$db."' ORDER BY TABLE_NAME";
		else 
			$sql = "SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME NOT LIKE 'magrathea%' ORDER BY TABLE_NAME";

		$tables = $magdb->queryAll($sql);
		return $tables;
	} catch (Exception $ex){
		$error_msg = "Error: ".$ex->getMessage();
	}
}

// load objects:
function getAllObjects(){
	$objects = null;
	try	{
		$mconfig = new MagratheaConfigFile();
		$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
		$mconfig->setFile("/../configs/magrathea_objects.conf");
		$objects = $mconfig->getConfig();
		unset($objects["relations"]);
		ksort($objects);
	} catch (Exception $ex){
		$error_msg = "Error: ".$ex->getMessage();
	}
	return $objects;
}

function getObject($obj_name){
	$objects = getAllObjects();
	return @$objects[$obj_name];
	foreach($objects as $obj){
		if( $obj["obj_name"] == $obj_name ) return $obj;
	}
}


function getObjectByTable($table_name){
	$objects = getAllObjects();
	foreach($objects as $object_name => $obj){
		if( $obj["table_name"] == $table_name ){
			$obj["obj_name"] = $object_name;
			return $obj;
		}
	}
}

// relations:
function GetRelations(){
	$relations = null;
	try	{
		$mconfig = new MagratheaConfigFile();
		$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
		$mconfig->setFile("/../configs/magrathea_objects.conf");
		@$relations = $mconfig->getConfig("relations");
	} catch (Exception $ex){
		$error_msg = "Error: ".$ex->getMessage();
	}
	return $relations;
}
function GetRelationsByObject($obj){
	$rels = GetRelations();
	$relations = array();
	if( count($rels) == 0 ) return $relations;
	$index = 0;
	foreach( $rels["rel_obj_base"] as $objbase ){
		if($objbase == $obj){
			array_push($relations, ExtractRelFromRelArray($rels, $index));
		}
		$index++;
	}
	return $relations;
}
function GetRelationByName($rel_name){
	$rels = GetRelations();
	if( is_null($rels) ) return null;
	$index = 0;
	foreach( $rels["rel_name"] as $rel ){
		if($rel == $rel_name){
			return ExtractRelFromRelArray($rels, $index);
		}
		$index++;
	}
}

function ExtractRelFromRelArray($rel_arr, $index){
	$relation = array();
	$relation["rel_name"] = $rel_arr["rel_name"][$index];
	$relation["rel_obj_base"] = $rel_arr["rel_obj_base"][$index];
	$relation["rel_type"] = $rel_arr["rel_type"][$index];
	$relation["rel_type_text"] = $rel_arr["rel_type_text"][$index];
	$relation["rel_object"] = $rel_arr["rel_object"][$index];
	$relation["rel_field"] = $rel_arr["rel_field"][$index];
	$relation["rel_property"] = $rel_arr["rel_property"][$index];
	$relation["rel_method"] = $rel_arr["rel_method"][$index];
	return $relation;
}


?>