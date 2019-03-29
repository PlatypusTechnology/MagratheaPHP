<?php

/**
* 
* Creates a server using Magrathea Tools to respond Json files
**/
class MagratheaApi {

	public $control = "Home";
	public $action = "Index";
	public $params = array();
	public $returnRaw = false;

	protected static $inst = null;

	// authorization
	public $authClass = false;
	public $baseAuth = false;

	private $endpoints = array();

	/**
	 * Constructor...
	 */
	private function __construct(){
		$endpoints["GET"] = array();
		$endpoints["POST"] = array();
		$endpoints["PUT"] = array();
		$endpoints["DELETE"] = array();
	}

	/**
	 * Singleton...
	 */
	public static function Instance() {
		if(!isset(self::$inst)){
			self::$inst = new MagratheaApi();
		}
		return self::$inst;
	}

	/**
	 * Start the server, getting base calls
	 */
	public function Start(){
		if(!@empty($_GET["magrathea_control"])) self::$inst->control = $_GET["magrathea_control"];
		if(!@empty($_GET["magrathea_action"])) self::$inst->action = $_GET["magrathea_action"];
		if(!@empty($_GET["magrathea_params"])) self::$inst->params = $_GET["magrathea_params"];
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type');
		return $this;
	}

	/**
	 * includes header to allow all
	 * @return 		itself
	 */
	public function AllowAll(){
		header('Access-Control-Allow-Origin: *');
		return $this;
	}

	/**
	 * includes header to allow all
	 * @param 	array 	$condition 	condition for header
	 * @return  itself
	 */
	public function Allow($allowedOrigins){
		if (in_array($_SERVER["HTTP_ORIGIN"], $allowedOrigins)) {
			header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
		}
		return $this;
	}

	/**
	 * Api will return the result instead of printing it
	 * @return 		itself
	 */
	public function SetRaw() {
		$this->returnRaw = true;
		return $this;
	}

	/**
	 * defines basic authorization function
	 * @param 	object 		$authClass 	class with authorization functions
	 * @param 	string 		$function 	basic authorization function name
	 * @return  itself
	 */
	public function BaseAuthorization($authClass, $function) {
		$this->authClass = $authClass;
		$this->baseAuth = $function;
		return $this;
	}

	private function getAuthFunction($auth) {
		if($auth === false) {
			return false;
		} else if($auth === true) {
			return $this->baseAuth;
		} else {
			return $auth;
		}		
	}

	/**
	 * includes header to allow all
	 * @param 	string 	 $url 				url for Crud
	 * @param 	class 	 $control 		control where crud function will be. They are: Create, Read, Update and Delete
	 * @param 	object 	 $auth 				function that returns authorization for execution. "false" for public API
	 * @return  itself
	 */
	public function Crud($url, $control, $auth=true) {
		$authFunction = $this->getAuthFunction($auth);
		$this->endpoints["POST"][$url] = [ "control" => $control, "action" => "Create", "auth" => $authFunction ];
		$this->endpoints["GET"][$url] = [ "control" => $control, "action" => "Read", "auth" => $authFunction ];
		$this->endpoints["GET"][$url."/:id"] = [ "control" => $control, "action" => "Read", "auth" => $authFunction ];
		$this->endpoints["PUT"][$url."/:id"] = [ "control" => $control, "action" => "Update", "auth" => $authFunction ];
		$this->endpoints["DELETE"][$url."/:id"] = [ "control" => $control, "action" => "Delete", "auth" => $authFunction ];
		return $this;
	}

	/**
	 * includes header to allow all
	 * @param 	string 	 $method			method for custom URL
	 * @param 	string 	 $url 				custom URL
	 * @param 	class 	 $control 		control where crud function will be. They are: Create, Read, Update and Delete
	 * @param 	string 	 $function		function to be called from control
	 * @param 	object 	 $auth 				function that returns authorization for execution. "false" for public API
	 * @return  itself
	 */
	public function Add($method, $url, $control, $function, $auth=true) {
		$method = strtoupper($method);
		$this->endpoints[$method][$url] = ["control" => $control, "action" => $function, "auth" => $this->getAuthFunction($auth)];
		return $this;
	}

	/**
	 * print all urls
	 * @return 		itself
	 */
	public function Debug() {
//		p_r($this->endpoints);
		$baseUrls = array();
		foreach ($this->endpoints as $method => $functions) {
			foreach ($functions as $url => $fn) {
				$params = array();
				$urlPieces = explode("/", $url);
				$base = $urlPieces[0];
				if(!$baseUrls[$base]) $baseUrls[$base] = array();
				if(!$baseUrls[$base][$method]) $baseUrls[$base][$method] = array();
				foreach ($urlPieces as $piece) {
					if($piece[0] == ":") array_push($params, substr($piece, 1));
				}

				$baseUrls[$base][$method][$url] = [
					"control" => get_class($fn["control"]),
					"action" => $fn["action"],
					"auth" => $fn["auth"],
					"args" => "(".(count($params) > 0 ? "['".implode("','", $params)."']" : "").")"
				];
			}
		}

		ksort($baseUrls);

		foreach ($baseUrls as $model => $methods) {
			echo "<h3>".$model.":</h3>";
			foreach ($methods as $method => $api) {
				echo "<h5>(".$method.")</h5>";
				echo "<ul>";
				foreach ($api as $url => $data) {
					echo "<li>/".$url." => ".$data["control"]."->".$data["action"].$data["args"]."; –– –– –– ".($data["auth"] ? "Authentication: (".$data["auth"].")" : "PUBLIC")."</li>";
				}
				echo "</ul>";
			}
			echo "<hr/>";
		}
		return $this;
	}

	private function CompareRoute($route, $url) {
//		echo "comparing; "; p_r($route); p_r($url);
		if($route == $url) return true;
		if(count($route) != count($url)) return false;
		if($route[0] != $url[0]) return false;
		for ($i=1; $i < count($route); $i++) {
			if($route[$i][0] == ":") {
				continue;
			} else {
				if($route[$i] != $url[$i]) return false;
			}
		}
		return true;
	}
	private function FindRoute($url, $apiUrls) {
//		echo "searching route: "; p_r($url); p_r($apiUrls);
		if(!$apiUrls) return false;
		foreach ($apiUrls as $apiUrl => $value) {
			$route = explode("/", $apiUrl);
			if($this->CompareRoute($route, $url)) return $apiUrl;
		}
		return false;
	}

	private function GetParamsFromRoute($route, $url) {
		if(strpos($route, ':') == false) return false;
		$params = array();
		$r = explode("/", $route);
		for ($i=1; $i < count($r); $i++) {
			if($r[$i][0] == ":") {
				$paramName = substr($r[$i], 1);
				$params[$paramName] = $url[$i];
			}
		}
		return $params;
	}

	private function getMethod() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			$host = $_SERVER['HTTP_ORIGIN'];
			$realMethod = $_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"];
			header('Access-Control-Allow-Origin: '.$host);
			header('Access-Control-Allow-Headers: Authorization, Content-Type');
			header('Access-Control-Allow-Methods: '.$realMethod);
			header('Access-Control-Max-Age: 1728000');
			header("Content-Length: 0");
			header("Content-Type: text/plain");
			exit(0);
		} else { return $method; }
	}

	/**
	 * Start the server, getting base calls
	 * @return 		response or nothing
	 */
	public function Run($returnRaw = false) {
		$urlCtrl = $_GET["magrathea_control"];
		$action = @$_GET["magrathea_action"];
		$params = @$_GET["magrathea_params"];
		$method = $this->getMethod();
		$this->returnRaw = $returnRaw;

		$fullUrl = strtolower($urlCtrl."/".$action."/".$params);
		return $this->ExecuteUrl($fullUrl, $method);
	}

	/**
	 * Execute URL
	 * @return 		response or nothing
	 */
	public function ExecuteUrl($fullUrl, $method="GET") {
		$url = explode("/", $fullUrl);
		$url = array_filter($url);

		$endpoints = @$this->endpoints[$method];
		$route = $this->FindRoute($url, $endpoints);

		if(!$route) {
			return $this->Return404();
		}

		$ctrl = $endpoints[$route];

		$control = $ctrl["control"];
		$fn = $ctrl["action"];
		$auth = $ctrl["auth"];
		if($auth) {
			if(!$this->authClass->$auth()) {
				$this->ReturnError(401, "Authorization Failed (".$auth." = false)");
			}
		}
		$params = $this->GetParamsFromRoute($route, $url);

		try {
			if($params) {
				$data = $control->$fn($params);
			} else {
				$data = $control->$fn();
			}
			return $this->ReturnSuccess($data);
		} catch (Exception $ex) {
			return $this->ReturnError($ex->getCode(), $ex->getMessage());
		}
	}

	/**
	 * returns the sent parameters in JSON format - and ends the execution with "die";
	 * @param 	object 		$response 		parameter to be printed in json
	 */
	public function Json($response){
		if($this->returnRaw) return $response;
		header('Content-Type: application/json');
		echo json_encode($response);
		die;
	}

	/**
	 * returns a 404 error for url not found
	 */
	private function Return404() {
		$method = $_SERVER['REQUEST_METHOD'];
		$url = $_GET["magrathea_control"];
		if(@$_GET["magrathea_action"]) $url.= "/".$_GET["magrathea_action"];
		if(@$_GET["magrathea_params"]) $url.= "/".$_GET["magrathea_params"];
		$message = "(".$method.") > /".$url." is not a valid endpoint";
		return $this->ReturnError(404, $message);
	}

	/**
	 * returns a json error message
	 * @param 	string 		$code 			error code
	 * @param 	string 		$message 		error message
	 * @param 	any 			$data 			error data
	 */
	public function ReturnError($code=500, $message="", $data=null) {
		return $this->Json(array(
			"success" => false,
			"error" => $data,
			"code" => $code,
			"message" => $message
		));
	}

	/**
	 * returns a successful json response
	 * @param 	any 			$data 			response data
	 */
	public function ReturnSuccess($data) {
		return $this->Json(array(
			"success" => true,
			"data" => $data
		));
	}
}


/**
* 
* Control for Create, Read, List, Update, Delete
**/
class MagratheaApiControl {
	
	protected $model = null;
	protected $service = null;

	public function GetPut() {
		if($_SERVER["PUT"]) return $_SERVER["PUT"];
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
			parse_str(file_get_contents("php://input"), $_PUT);
			foreach ($_PUT as $key => $value){
				unset($_PUT[$key]);
				$_PUT[str_replace('amp;', '', $key)] = $value;
			}
			$_REQUEST = array_merge($_REQUEST, $_PUT);
		}
		return $_PUT;
	}

	public function List() {
		try {
			return $this->service->GetAll();
		} catch(Exception $ex) {
			throw $ex;
		}
	}
	public function Read($params=false) {
		try {
			if(!$params) return $this->List();
			$id = $params["id"];
			return new $this->model($id);
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function Create() {
		$m = new $this->model();
		$data = $_POST;
		if($data["id"]) unset($data["id"]);
		foreach ($data as $key => $value) {
			if(property_exists($m, $key)) {
				$m->$key = $value;
			}
		}
		try {
			if($m->Insert()) {
				return $m;
			}
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function Update($params=false) {
		$id = $params["id"];
		$m = new $this->model($id);
		$data = $this->GetPut();
		if(!$data) throw new Exception("Empty Data Sent", 500);
		foreach ($data as $key => $value) {
			if(property_exists($m, $key)) {
				$m->$key = $value;
			}
		}
		try {
			if($m->Update()) return $m;
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function Delete($params=false) {
		if(!$params) throw new Exception("Empty Data Sent", 500);
		$id = $params["id"];
		$m = new $this->model($id);
		try {
			return $m->Delete();
		} catch(Exception $ex) {
			throw $ex;
		}
	}
}

?>