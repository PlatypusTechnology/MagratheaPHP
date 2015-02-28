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
####	created: 2012-12 by Paulo Martins
####
#######################################################################################

/**
 * define routes and gives main paths for controllers and actions
 */
class MagratheaRoute {

	private $defaultControl = "Home";
	private $defaultAction = "Index";
	private $routes = null;

	protected static $inst = null;
	public static function Instance(){
		if(!isset(self::$inst)){
			self::$inst = new MagratheaRoute();
		}
		return self::$inst;
	}
	/**
	 * private constructor for singleton
	 */
	private function MagratheaRoute(){}

	/**
	 * Set an array of routes
	 * @param 	array 	$routes 	routes to follow
	 * @return  itself
	 */
	public function SetRoute($routes){
		$this->routes = array_change_key_case( array_map('strtolower', $routes), CASE_LOWER );
		return $this;
	}

	/**
	 * Set default control and action
	 * @param string $control default control
	 * @param string $action  default action
	 * @return  itself
	 */
	public function Defaults($control="Home", $action="Index"){
		$this->defaultControl = $control;
		$this->defaultAction = $action;
		return $this;
	}

	/**
	 * Creates the route
	 * @param 	*string 	&$control 		var to control
	 * @param 	*string 	&$action  		var to action
	 * @param 	*array 		&$params  		var to parameters
	 * @return  itself
	 */
	public function Route(&$control, &$action, &$params){
		$params = array();
		if(!@empty($_GET["control"])) $control = $_GET["control"];
		if(!@empty($_GET["action"])) $action = $_GET["action"];
		if(!@empty($_GET["params"])) $params = $_GET["params"];
		$control = strtolower($control);
		$action = strtolower($action);
		$this->LookForRoute($control, $action, $params);
		if(empty($control)) $control = $this->defaultControl;
		if(empty($action)) $action = $this->defaultAction;
		return $this;
	}

	/**
	 * Look for sent route and check if there's an alternative
	 * @param 	string 	$control 	control
	 * @param 	string 	$action  	action
	 * @param 	array 	$params  	params
	 * @todo so far we are only accepting full routes. I want this to accept controls, action and everything else!
	 */
	private function LookForRoute(&$control, &$action, &$params){
		$url = $this->RebuildUrl($control, $action, $params);
		if( empty($this->routes[$url]) ) return;
		$newRoute = $this->UnbuildUrl($this->routes[$url]);
		if(!empty($newRoute["control"])) $control = $newRoute["control"];
		if(!empty($newRoute["action"])) $action = $newRoute["action"];
		if(!empty($newRoute["params"])) $params = $newRoute["params"];
	}

	/**
	 * gets data and rebuilds the sent url
	 * @param 	string 	$control 	control
	 * @param 	string 	$action  	action
	 * @param 	array 	$params  	params
	 * @return 	string 	url rebuilt
	 */
	public function RebuildUrl($control="", $action="", $params=""){
		$url = $control;
		if(empty($action)) return $url;
		$url .= "/".$action;
		if(empty($params)) return $url;
		$url .= "/".$params;
		return $url;
	}

	/**
	 * gets an url, splits it and returns an array with control, action and params
	 * @param 	string 		$url 		url to be parsed
	 * @return 	array 		array("control" => ..., "action" => ..., "params" => ...);
	 * @todo  test this further...
	 */
	public function UnbuildUrl($url){
		$parse = explode("/", $url);
		$ret = array();
		$ret["control"] = $parse[0];
		if(!empty($parse[1])) $ret["action"] = $parse[1];
		if(!empty($parse[2])) $ret["params"] = $parse[2];
		return $ret;
	}


}


?>