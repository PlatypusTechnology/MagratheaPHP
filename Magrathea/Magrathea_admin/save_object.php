<?php

require ("admin_load.php");

	$data = $_POST;
	$object_name = $data["object_name"];

//	p_r($data);

	$object_data = getObject($object_name);
	
	$mconfig = new MagratheaConfigFile();
	$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
	$mconfig->setFile("/../configs/magrathea_objects.conf");
	$objdata = $mconfig->getConfig();

	/*
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Oh, crap! =(</strong><br/>
			You forgot to tell us the name of the object, boy...
		</div>
		<?
		die;
	*/

	$lazy_load = $data["lazy_load"];

	// relations:
	$relations = @$objdata["relations"];
	$i_rel_obj = 0;
	if( @$data["rel_type"] != null ){
		foreach( $data["rel_type"] as $type){
			$type_text = $data["rel_type_text"][$i_rel_obj];
			$object = $data["rel_object"][$i_rel_obj];
			$field = $data["rel_field"][$i_rel_obj];
			$rel_name = "rel_".$object_name."_".$type."_".$object;
	
			$property = $data[$rel_name."_property"];
			$method = $data[$rel_name."_method"];

			if( empty($property) )
				$property = ($type == "belong_to" ? $object : $object."s" );
			if( empty($method) )
				$method = ($type == "belong_to" ? "Get".$object : "Get".$object."s" );

			$rel_id = @count($relations["rel_name"]);
			$i = 0;
			if( $rel_id > 0 ){
				foreach($relations["rel_name"] as $already_exists_name){
					if( $already_exists_name == $rel_name ) $rel_id = $i;
					else $i++;
				}
			}
	
			$relations["rel_name"][$rel_id] = $rel_name;
			$relations["rel_obj_base"][$rel_id] = $object_name;
			$relations["rel_type"][$rel_id] = $type;
			$relations["rel_type_text"][$rel_id] = $type_text;
			$relations["rel_object"][$rel_id] = $object;
			$relations["rel_field"][$rel_id] = $field;
			$relations["rel_property"][$rel_id] = $property;
			$relations["rel_method"][$rel_id] = $method;
	
			// create mirror relation:
			$mirror_obj_base = $object;
			$mirror_obj = $object_name;
			switch($type){
				case "belongs_to":
					$mirror_type = "has_many";
					$mirror_type_text = "has many";
					$mirror_property = $mirror_obj."s";
					$mirror_method = "Get".$mirror_obj."s";
				break;
				case "has_many":
					$mirror_type = "belongs_to";
					$mirror_type_text = "belongs to";
					$mirror_property = $mirror_obj;
					$mirror_method = "Get".$mirror_obj;
				break;
				default:
					$mirror_type = $type;
					$mirror_type_text = $type_text;
					$mirror_property = $mirror_obj."s";
					$mirror_method = "Get".$mirror_obj."s";
				break;
			}
			$mirror_name = "rel_".$mirror_obj_base."_".$mirror_type."_".$mirror_obj;

			$rel_id = @count($relations["rel_name"]);
			$i = 0;
			foreach($relations["rel_name"] as $already_exists_name){
				if( $already_exists_name == $mirror_name ) $rel_id = $i;
				else $i++;
			}
	
			$relations["rel_name"][$rel_id] = $mirror_name;
			$relations["rel_obj_base"][$rel_id] = $mirror_obj_base;
			$relations["rel_type"][$rel_id] = $mirror_type;
			$relations["rel_type_text"][$rel_id] = $mirror_type_text;
			$relations["rel_object"][$rel_id] = $mirror_obj;
			$relations["rel_field"][$rel_id] = $field;
			$relations["rel_property"][$rel_id] = $mirror_property;
			$relations["rel_method"][$rel_id] = $mirror_method;
	
			$i_rel_obj++;
		}
	}

	$objdata[$object_name] = $object_data;
	$objdata[$object_name]["lazy_load"] = $lazy_load;
	$objdata["relations"] = $relations;
	
	$mconfig->setConfig($objdata);
	if( !@$mconfig->Save(true) ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... error saving object!</strong><br/>
			Could not save object config file. Please, be sure that PHP can write in the folder "Magrathea/configs/"...
		</div>
		<?
		die;
	}

?>
<!--true--->
<div class="alert alert-success">
	<button class="close" data-dismiss="alert" type="button">×</button>
	<strong>Yeah, baby!</strong><br/>
	Object was saved.
	<?=(empty($mirror_name) ? "" : "<br/>Mirror relations were also created in the related objects...")?>
</div>

