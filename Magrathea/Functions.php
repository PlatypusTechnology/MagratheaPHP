<?php

#######################################################################################
####
####	MAGRATHEA PHP
####	v. 1.0
####
####	Magrathea by Paulo Henrique Martins
####	Platypus technology
####
#######################################################################################
####
####	FUNCTIONS
####	created: 2012-12 by Paulo Martins
####
#######################################################################################

function p_r($debugme, $beautyme=false){
	if( $beautyme ){
		echo nice_p_r($debugme); 
	} else { 
		echo "<pre>"; print_r($debugme); echo "</pre>";
	}
}

function nice_p_r($debugme, $prev_char = ""){
	echo (empty($prev_char) ? "<div>" : "");
	if( is_array( $debugme ) ){
		echo $prev_char."<span class='p_r_title'> Array: [</span><br/><div style='margin-right: 20px;'>";
		foreach( $debugme as $key => $item ){
			echo "<div style='padding-right: 20px;'><span class='p_r_title'>[".$key."] =></span><br/>";
			echo nice_p_r($item, $prev_char."&nbsp;");
			echo "</div>";
		}
		echo $prev_char."</div><hr/>";
	} else {
		echo $prev_char.$debugme;
	}
	echo (empty($prev_char) ? "</div>" : "");
}

function magrathea_printFields($fields_arr, $selected = null){
	$options = "";
	$selected = false;
	foreach($fields_arr as $field){
		if( $field == $selected ){
			$selected = true;
			$options .= "<option value='".$field."' selected>".$field."</option>";
		} else {
			$options .= "<option value='".$field."'>".$field."</option>";
		}
	}
	echo $options;
	return $selected;
}

function magrathea_getTypesArr(){
	$types = array("int", "string", "text", "float", "datetime");
	return $types;
}

function now(){
	return date("Y-m-d H:i:s");
}

function mascara($val, $mask) { $maskared = ''; $k = 0; for($i = 0; $i<=strlen($mask)-1; $i++) { if($mask[$i] == '#') { if(isset($val[$k])) $maskared .= $val[$k++]; } else { if(isset($mask[$i])) $maskared .= $mask[$i]; } } return $maskared; }



