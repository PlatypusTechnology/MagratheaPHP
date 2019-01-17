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
	 * Start the server, getting base calls
	 */
	public static function Start(){
		if(!isset(self::$inst)){
			self::$inst = new MagratheaApi();
		}
		if(!@empty($_GET["magrathea_control"])) self::$inst->control = $_GET["magrathea_control"];
		if(!@empty($_GET["magrathea_action"])) self::$inst->action = $_GET["magrathea_action"];
		if(!@empty($_GET["magrathea_params"])) self::$inst->params = $_GET["magrathea_params"];
		return self::$inst;
	}

	/**
	 * includes header to allow all
	 * @return 		itself
	 */
	public function AllowAll(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type');
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
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type');
		return $this;
	}

	/**
	 * includes header to allow all
	 * @param 	string 	 $url 				url for Crud
	 * @param 	class 	 $control 		control where crud function will be. They are: Create, Read, Update and Delete
	 * @return  itself
	 */
	public function Crud($url, $control) {
		$this->endpoints["POST"][$url] = array("control" => $control, "action" => "Create");
		$this->endpoints["GET"][$url] = array("control" => $control, "action" => "Read");
		$this->endpoints["GET"][$url."/:id"] = array("control" => $control, "action" => "Read");
		$this->endpoints["PUT"][$url."/:id"] = array("control" => $control, "action" => "Update");
		$this->endpoints["DELETE"][$url."/:id"] = array("control" => $control, "action" => "Delete");
		return $this;
	}

	/**
	 * includes header to allow all
	 * @param 	string 	 $method			method for custom URL
	 * @param 	string 	 $url 				custom URL
	 * @param 	class 	 $control 		control where crud function will be. They are: Create, Read, Update and Delete
	 * @param 	string 	 $function		function to be called from control
	 * @return  itself
	 */
	public function Add($method, $url, $control, $function) {
		$method = strtoupper($method);
		$this->endpoints[$method][$url] = array("control" => $control, "action" => $function);
		return $this;
	}

	/**
	 * print all urls
	 * @return 		itself
	 */
	public function Debug() {
		foreach ($this->endpoints as $method => $functions) {
			echo "<b>".$method.":</b><br/>";
			echo "<ul>";
			foreach ($functions as $url => $fn) {
				$params = array();
				$urlPieces = explode("/", $url);
				foreach ($urlPieces as $piece) {
					if($piece[0] == ":") array_push($params, substr($piece, 1));
				}
				echo "<li>/".$url." => ".get_class($fn["control"])."->".$fn["action"]."(".(count($params) > 0 ? "['".implode("','", $params)."']" : "").");</li>";
			}
			echo "</ul>";
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

	/**
	 * Start the server, getting base calls
	 * @return 		itself
	 */
	public function Run($returnRaw = false) {
		$urlCtrl = $_GET["magrathea_control"];
		$action = @$_GET["magrathea_action"];
		$params = @$_GET["magrathea_params"];
		$method = $_SERVER['REQUEST_METHOD'];
		$this->returnRaw = $returnRaw;

		$fullUrl = strtolower($urlCtrl."/".$action."/".$params);
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
		$params = $this->GetParamsFromRoute($route, $url);

		try {
			if($params) {
				$data = $control->$fn($params);
			} else {
				$data = $control->$fn();
			}
			return $this->ReturnSuccess($data);
		} catch (Exception $ex) {

			$this->ReturnError(500, $ex->getMessage(), $ex);
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

	public function Create($params) {
		$m = new $this->model();
		$data = $_POST;
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

	public function Update($params) {
		$id = $params["id"];
		$m = new $this->model($id);
		$data = $this->GetPut();
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

	public function Delete($params) {
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