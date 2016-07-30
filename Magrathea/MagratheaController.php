<?php

/**
 * This class will manage the controllers for displaying pages
 */
class MagratheaController {

	protected $Smarty;

	public $forceMethodCall = false;
	protected $displayStatic = false;
	private $staticPage = false;

	/**
	*	Just starts Smarty (if is not started yet...)
	*/
	public function StartSmarty(){
		global $Smarty;
		$this->Smarty = $Smarty;
	}

	/**
	 * Gets Smarty object statically
	 * @return  	Smarty 		Smarty object.
	 */
	public static function GetSmarty(){
		global $Smarty;
		return $Smarty;
	}

	/**
	*	Calls another action without changing the url
	*
	*	@param 	string 	$control 	Control to be called
	* 	@param 	string 	$action 	Action to be called inside the control
	*/
	public function Redirect($control, $action){
		self::Load($control, $action);
		return;
	}

	/**
	*	Forward to another page (changing the URL and reloading everything)
	*
	*	@param 	string 	$control 	Control to be called
	* 	@param 	string 	$action 	Action to be called inside the control
	*/
	public function ForwardTo($control, $action=null){
		if( $action )
			header("Location: /".$control."/".$action);
		else
			header("Location: /".$control);
		exit;
	}

	/**
	*	Allow static page generation
	*
	*	@param 		boolean 	$allow 	Can I save this page as a HTML for you?
	* 	@return 	itself
	*/
	public function AllowCache($allow){
		$this->displayStatic = $allow;
		return $this;
	}

	/**
	*	Formats a static page name, adding .html and fixing other issues...
	*	@param 		string 		$name 		Name of the static page 
	*/
	public function formatStaticPageName($name){
		$name = strtolower($name);
		if (!preg_match("{{(.htm(l)?)$/i}}", $name)) {
			$name = $name.".html";
		}
		return $name;
	}

	/**
	*	Sets a static name for the page that will be displayed.
	*	When $die is true, 
	*		if the page already exists, it will be displayed as it is and the code will be TERMINATED!
	*	@param 	string 	$name 	Static name page
	*	@param 	boolean	$die 	Terminate code if static found
	*/
	public function GetStatic($name, $die=true){
		if(!$this->displayStatic) return false;
		$staticName = $this->formatStaticPageName($name);
		$appFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
		$filePath = $appFolder."/Static/".$staticName;
		if( file_exists($filePath) ){
			$code = file_get_contents($filePath);
			print($code);
			if($die) die();
			return true;
		} else {
			$this->staticPage = $staticName;
			return false;
		}
	}

	/**
	*	Displays a template with Smarty
	*	@param 	string 	$template 	Page to display
	*/
	public function Display($template){
		if(!$this->staticPage) {
			$this->Smarty->display($template);
		} else {
			$code = $this->Smarty->fetch($template);
			$code .= "\n<!-- page generated at ".date("Y-m-d h:i:s")." -->";
			$appFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
			$filePath = $appFolder."/Static/".$this->staticPage;
			$file_handler = @fopen($filePath, 'w');
			fwrite($file_handler, $code);
			fclose($file_handler);
			echo $code;
		}
	}



	/**
	*	With a given control name and action, calls the right function
	*	It will start a new object `$controlName` and call the `$action` in it
	*	@param 	string 	$controlName 	Control to be called
	* 	@param 	string 	$action 		Action to be called inside the control
	*	@param 	string 	$params 		Params to send to the given action
	*/
	public static function Load($control, $action, $params=""){
		$controlName = ucfirst(strtolower($control))."Controller";
		try {
			if(!class_exists($controlName)){
				$ex = new MagratheaControllerException("Class ".$controlName." does not exist! - parameters called [".$control."/".$action."/".$params."]");
				$ex->killerError = false;
				throw $ex;
			}
			$control = new $controlName;
			$control->StartSmarty();
			$control->$action($params);
		} catch (Exception $e) {
			throw $e;
			self::ErrorHandle($e);
		}
	}

	/**
	 * gives the sent response in json
	 * @param object $response object to convert to Json
	 */
	protected function Json($response){
		// we remove the debug for printing a Json!
		MagratheaDebugger::Instance()->SetType(MagratheaDebugger::NONE);
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}


	/**
	 * Include all Controllers presents on `Controllers` folder
	 */
	public static function IncludeAllControllers(){
		$modelsFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/Controls";
		if($handle = @opendir($modelsFolder)){
			while (false !== ($file = readdir($handle))) {
				$filename = explode('.', $file);
				$ext = array_pop($filename);
				if(empty($ext) || $file[0] == "_") continue;
				if($ext == "php"){
					include_once($modelsFolder."/".$file);
				}
			}
			closedir($handle);
		}
	}

	/**
	*	Get all static files and return them as an array
	*	@return 	array 	static pages found
	*/
	public static function GetAllStatic(){
		$appFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
		$staticPath = $appFolder."/Static/";
		$results = scandir($staticPath);
		$statics = array();
		foreach ($results as $result) {
		    if ($result === '.' or $result === '..') continue;
			array_push($statics, $result);
		}
		sort($statics);
		return $statics;
	}

	/**
	*	Removes all static files from static folder
	*	@return 	string 		exec code output
	*/
	public static function ClearStatic(){
		$appFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
		$staticPath = realpath($appFolder."/Static");
		$output = shell_exec("rm ".$staticPath."/*");
		return $output;
	}



	public static function ErrorHandle($ex){
		if(is_a($ex, "MagratheaException")){
			$ex->display();
			die;
		} 
		die($ex->getMessage());
	}

	public function __call($method_name, $args = array()){
		if(method_exists($this->Smarty, $method_name)){
			return call_user_func_array(array(&$this->Smarty, $method_name), $args);
		} else {
			throw new MagratheaControllerException("Function could not be found (even in Smarty):".$method_name);
			
		}
	}
	
}


?>
