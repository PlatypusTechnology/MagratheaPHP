<?php

/**
* Class for debugging and logging Control
* 
*/

/**
 * Debugs what is sent, according with debug configurations
 * @param 	object 	$this object to debug
 * @todo  debug_backtrace
 */
function Debug($this){
	MagratheaDebugger::Instance()->Add($this);
}

class MagratheaDebugger {

	const NONE = 0;
	const LOG = 2;
	const DEBUG = 3;
	const DEV = 4;

	private $debugItems = array();
	private $debugType = self::LOG;
	private $oldDebugType = self::NONE;
	protected static $inst = null;

	// this is a singleton!
	private function __construct(){ }

	/**
	* Static singleton way to get the debugger instance
	*/
	public static function Instance(){
		if (self::$inst === null) {
			self::$inst = new MagratheaDebugger();
		}
		return self::$inst;
	}
	public function MagratheaDebugger(){
	}

	/**
	* Sets the debugger method
	* It can be: *DEV*, *DEBUG*, *LOG*, *NONE* =>
	* **MagratheaDebugger::DEV** = Will print the debugs as it appears in the code
	* **MagratheaDebugger::DEBUG** = Will store all the debugs and print it later
	* **MagratheaDebugger::LOG** = Will log queries and other debugs in the code
	* **MagratheaDebugger::NONE** = Well... nothing to do, heh?
	* Default: **LOG**
	*
	* @param 	$dType 	string 	type to be set
	*/
	public function SetType($dType){
		$this->debugType = strtolower($dType);
	}

	/**
	 * Trace error location
	 */
	public function Trace(){
		echo "<pre>"; debug_backtrace(); echo "</pre>";
	}

	/**
	* Sets a debugger type temporarily
	* (usefull when need to check a specific operation, for example)
	*
	*	@param 	string 	$dType 	type to be temporarily set
	*/
	public function SetTemp($dType){
		$this->oldDebugType = $this->debugType;
		$this->debugType = $dType;
	}

	/**
	* After temporarily setting a debugging type, gets it back to what it was
	*
	*/
	public function BackTemp(){
		$this->debugType = $this->oldDebugType;
	}

	/**
	* Returns the debug type
	*
	* @return string Debug type (*Dev*, *Debug*, *Log*, *None*)
	*/
	public function GetType(){
		return $this->debugType;
	}

	/**
	* Add an item to the debug array object
	*
	* 	@param 	string 	$debug 		debug item
	*/
	public function Add($debug){
		switch ($this->debugType) {
			case @NONE:
				return;
				break;
			case @LOG:
				MagratheaLogger::Log($debug);
				return;
				break;
			case @DEV:
				$this->printsDebug($debug);
				$this->Trace();
			case @DEBUG:
				array_push($this->debugItems, $debug);
				break;
		}
	}

	/**
	 * Adds an error to the debugger
	 * @param Exception		$err 	Exception
	 */
	public function Error($err){
		$this->Add($err->getMessage());
	}

	/** 
	* Adds a query to the debug
	*
	*	@param 	string 	$sql 	query to be debugged
	* 	@param 	string 	$values 	values to be added to the query
	*/
	public function AddQuery($sql, $values){
		if($this->debugType == @NONE) return;
		$logThis = "query run: [".$sql."]";
		if(!is_null($values)){
			$logThis .= " - values: [".implode(',', $values)."]";
		}
		$this->Add($logThis);
	}

	/**
	* Prints the debug
	* 	@todo  print it in a wonderful way in the end of the page
	*/
	public function Show(){
		foreach ($this->debugItems as $item) {
			$this->printsDebug($item);
		}
	}

	/**
	 * prints every single line in p_r()
	 * @param  	object 		$debugToPrint 		object to debug
	 */	
	private function printsDebug($debugToPrint){
		p_r($debugToPrint);

	}



}




?>