<?php

/**
* This class will manage the controllers for displaying pages
* 
*/

class MagratheaController {

	protected $Smarty;

	public $forceMethodCall = false;
	public $displayStatic = false;

	/**
	*	Just starts Smarty (if is not started yet...)
	*/
	public function StartSmarty(){
		global $Smarty;
		$this->Smarty = $Smarty;
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
	public function ForwardTo($control, $action){
		header("Location: /".$control."/".$action);
	}

	/**
	*	Displays a template with Smarty
	*
	*	@param 	string 	$template 	Page to display
	*/
	public function Display($template){
		$this->Smarty->display($template);
	}

	/**
	*	Creates an static page with the code and displays it
	*
	*	@param 	string 	$staticName 	Name of the static page to be generated
	* 	@param 	string 	$template 		Template to display
	*/
	public function DisplayStatic($staticName, $template){
		$staticName = strtolower($staticName);
		$code = $this->Smarty->fetch($template);
		$code .= "\n<!-- code generated at ".date("Y-m-d h:i:s")." -->";
		$appFolder = MagratheaConfigStatic::GetConfigFromDefault("/site_path");
		$filePath = $appFolder."/Static/".$staticName;
		$file_handler = fopen($filePath, 'w');
		fwrite($file_handler, $code);
		fclose($file_handler);
		$this->LoadIfExists($staticName);
	}

	/**
	*	Show the static page with the given name, if it exists
	*
	*	@param 	string 	$staticName 	Name of the page to be shown
	*
	*	@return 	boolean	 	True if the page exists (and displays it); False if it doesn't 
	*/
	public static function LoadIfExists($staticName){
		$staticName = strtolower($staticName);
		$appFolder = MagratheaConfigStatic::GetConfigFromDefault("/site_path");
		$filePath = $appFolder."/Static/".$staticName;
		if( file_exists($filePath) ){
			$code = file_get_contents($filePath);
			print($code);
			return true;
		} else {
			return false;
		}
	}

	/**
	*	With a given control name and action, calls the right function
	*	It will start a new object `$controlName` and call the `$action` in it
	*
	*	@param 	string 	$controlName 	Control to be called
	* 	@param 	string 	$action 		Action to be called inside the control
	*	@param 	string 	$params 		Params to send to the given action
	*/
	public static function Load($controlName, $action, $params=""){
		$controlName = $controlName."Controller";

		try {
			if(!class_exists($controlName)){
				$ex = new MagratheaControllerException("Class ".$controlName." does not exist!");
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