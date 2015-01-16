<?php

/**
* Class for debugging and logging Control
* 
*/


function Debug($this){
	MagratheaDebugger::Instance()->Add($this);
}

class MagratheaDebugger {

	private $debugItems = array();
	private $debugType = "none";
	private $oldDebugType = "none";
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
	* It can be: *Dev*, *Debug*, *Log*, *None*
	* **Dev** Will print the debugs as it appears in the code
	* **Debug** Will store all the debugs and print it later
	* **Log** Will log queries and other debugs in the code
	* **None** Well... nothing to do, heh?
	* Default: **Log**
	*
	* @param 	$dType 	string 	type to be set
	*/
	public function SetType($dType){
		$this->debugType = strtolower($dType);
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
			case 'none':
				return;
				break;
			case 'log':
				MagratheaLogger::Log($debug);
				return;
				break;
			case 'dev':
				$this->printsDebug($debug);
			case 'debug':
				array_push($this->debugItems, $debug);
				break;
		}
	}

	/** 
	* Adds a query to the debug
	*
	*	@param 	string 	$sql 	query to be debugged
	* 	@param 	string 	$values 	values to be added to the query
	*/
	public function AddQuery($sql, $values){
		if($this->debugType == 'none') return;
		$logThis = "query run: [".$sql."]";
		if(!is_null($values)){
			$logThis .= " - values: [".implode(',', $values)."]";
		}
		$this->Add($logThis);
	}

	/**
	* Prints the debug
	*/
	public function Show(){
		foreach ($this->debugItems as $item) {
			$this->printsDebug($item);
		}
	}

	private function printsDebug($debugToPrint){
		p_r($debugToPrint);

	}



}




?>