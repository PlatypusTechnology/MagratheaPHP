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

/**
 * Loads database configuration for the selected environment.
 * 	If no environment is sent, it will use the information from the default environment
 * @param 	string 		$env	Environment to load
 * @return 	MagratheaDatabase Instance
 */
function loadMagratheaEnv($env = null){
	global $magdb;
	if( empty($env) ){
		try {
			$env = MagratheaConfig::Instance()->GetEnvironment();
		} catch(Exception $ex) { return false; }
		if(empty($env)) return false;
	} else {
		MagratheaConfig::Instance()->SetDefaultEnvironment($env);
	}
	try {
		$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
		date_default_timezone_set( MagratheaConfig::Instance()->GetConfig("general/time_zone") );

		$magdb = MagratheaDatabase::Instance();
		$conn = $magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
	} catch(Exception $ex) {
		throw $ex;
	}
	return $conn;
}

//.$trace[0]["file"].":".$trace[0]["line"]."\n"
/**
 * Prints easily and beautifully
 * @param 	object 		$debugme	Object to be printed
 * @param  	boolean  	$beautyme	How beautifull do you want your object printed?
 */
function p_r($debugme, $beautyme=false){
//	$trace = debug_backtrace();
	if( $beautyme ){
		echo nice_p_r($debugme); 
	} else { 
		echo "<pre>"; print_r($debugme); echo "</pre>";
	}
}

/**
 * Prints wonderfull debugs!
 * @param 	object 		$debugme 	Object to be printed
 * @param  	string  	$prev_char 	separator
 * @return  string  	nicely printed var
 */	
function nice_p_r($debugme, $prev_char = ""){
	$html = "";
	$html .= (empty($prev_char) ? "<div>" : "");
	if( is_array( $debugme ) ){
		$html .= $prev_char."<span class='p_r_title'> Array: [</span><br/><div style='margin-right: 20px;'>";
		foreach( $debugme as $key => $item ){
			$html .= "<div style='padding-right: 20px;'><span class='p_r_title'>[".$key."] =></span><br/>";
			$html .= nice_p_r($item, $prev_char."&nbsp;");
			$html .= "</div>";
		}
		$html .= $prev_char."</div><hr/>";
	} else {
		$html .= $prev_char.$debugme;
	}
	$html .= (empty($prev_char) ? "</div>" : "");
	return $html;
}

/**
 * dumps vars
 * @param 	object 		$debugme 	Object to be printed
 * @return  string  	nicely printed var
 */	
function dump($debugme){
	ob_start();
	var_dump($debugme);
	return ob_get_clean();
}

/**
 * Date of now - mySQL format
 * @return 	string 		Y-m-d H:i:s format of date
 */
function now(){
	return date("Y-m-d H:i:s");
}

/**
 * gets an array and prints a select
 * @param   array 		array to be printed
 * @param 	string 		type to be selected
 * @return 	boolean		is field selected?
 */
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

/**
 * Array of types available at Magrathea
 * @return  	array
 */
function magrathea_getTypesArr(){
	$types = array("int", "boolean", "string", "text", "float", "datetime");
	return $types;
}

/**
 * Function that will be executed after script is complete!
 * in Magrathea, will print debug, if available...
 * 	@todo  print debug in a beautifull way in the end of the page...
 */
function shutdown(){
	if(MagratheaDebugger::Instance()->GetType() == MagratheaDebugger::DEBUG){
		MagratheaDebugger::Instance()->Show();
	}
}
register_shutdown_function('shutdown');



