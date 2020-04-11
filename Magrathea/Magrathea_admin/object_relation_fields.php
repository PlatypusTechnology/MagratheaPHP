<?php

require ("admin_load.php");

	$obj_name = $_POST["object"];
	$obj_data = getObject($obj_name);

	$obj_fields = array();
	foreach($obj_data as $key => $item){
		if( substr($key, -6) == "_alias" ){
			$field_name = substr($key, 0, -6);
			if( $field_name == "created_at" || $field_name == "updated_at" ) continue;
			array_push($obj_fields, $field_name);
		}
	}

?>

use this field from <?=$obj_name?> to make the relation:&nbsp;
<select id="relation_field" name="relation_field" class='input-medium'>
	<?php
	foreach($obj_fields as $field){
		echo "<option value='".$field."'>".$field."</option>";
	}
	?>
</select>
