<?php

/**
* 
* Creates a server using Magrathea Tools to respond Json files
* 
**/
class MagratheaServer {

	/**
	 * Constructor...
	 */
	public function MagratheaServer(){
	}

	/**
	 * includes header to allow all
	 * @return 		itself
	 */
	public function AllowAll(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST'); 
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type');
		return $this;
	}

	/**
	 * Start he server, creating listeners to default actions
	 */
	public function Start(){
		$get = $_GET;
		$args = null;
		$action = "Wsdl";

		if(!empty($get)){
			$action=array_keys($get)[0];
			$args = array_shift($get);
		}
		$this->$action($args);
	}

	/**
	 * returns the sent parameters in JSON format - and ends the execution with "die";
	 * @param 	object 		$response 		parameter to be printed in json
	 */
	protected function Json($response){
		header('Content-Type: application/json');
		echo json_encode($response);
		die;
	}

	/**
	 * Prints an own summary of all the present functions in the server
	 */
	protected function Wsdl(){
		header('Content-Type: text/plain; charset=utf-8');
		$className = get_called_class();
		$methods = $this->getDeclaredMethods($className);
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		echo "=== * * { ".$className." } * * ==========================================================[MagratheaServer]=\n";
		echo "===\n";
		echo "=== CALLS:\n";
		foreach ($methods as $m) {
			echo "=== \t[".$url."?".$m."] \n";
		}
		echo "===\n===\n";
	}

	private function getDeclaredMethods($className) {
		$reflector = new ReflectionClass($className);
		$methodNames = array();
		$lowerClassName = strtolower($className);
		foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
			if (strtolower($method->class) == $lowerClassName) {
				$methodNames[] = $method->name;
			}
		}
		return $methodNames;
	}

}

?>