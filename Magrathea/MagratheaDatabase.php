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
####	Database Class
####	Database connection class
####	
####	created: 2012-12 by Paulo Martins
####
#######################################################################################


/**
* This class will provide a simulation of MagratheaDatabase
* 	queries will be saved on a file.
*/
class MagratheaDatabase{

	const FETCH_ASSOC = 1;
	const FETCH_OBJECT = 2;
	const FETCH_NUM = 3;
	const FETCH_ARRAY = 4;

	private $connDetails;
	private $fetchmode;

	private $count = 0;

	protected static $inst = null;

	/**
	* This is a singleton!
	* Constructor is private
	*/
	private function __construct(){
	}

	/**
	* This is a singleton!
	* Instance loader
	* @return 	result of MagratheaDebugger
	*/
	private function Simulate($fn, $sql, $values=null){
		$simulation =  "SIMULATING QUERY: (".$fn.")[".$sql."]";
		if(!is_null($values)){
			$simulation .= " - values: [".implode(',', $values)."]";
		}
		return MagratheaDebugger::Instance()->Add($simulation);
	}

	/**
	* This is a singleton!
	* Instance loader
	* @return 	MagratheaDatabase 	Instance of the object
	*/
	public static function Instance(){
		if (self::$inst === null) {
			self::$inst = new MagratheaDatabase();
		}
		return self::$inst;
	}
	
	/**
	* This is a singleton!
	* Should be called by private method Instance.
	* Don't implement new ones
	*/
	public function MagratheaDatabase(){
	}
	/**
	* Sets the connection array object
	* @param 	array 	$dsn_arr	array with connection data, as the sample:
	*								array(
	*						            'hostspec' => $host,
	*						            'database' => $database,
	*						            'username' => $username,
	*						            'password' => $password,
	*								);
	* @return  	itself
	*/
	public function SetConnectionArray($dsn_arr){
		$this->connDetails = $dsn_arr;
		return $this;
	}
	/**
	* Setups connection
	* @param 	string 	$host 			host address for connection
	* @param 	string 	$database		database name
	* @param 	string 	$username 		username for connection
	* @param 	string 	$password		password for connection
	* @return  	itself
	*/	
	public function SetConnection($host, $database, $username, $password, $port=null){
		$this->connDetails = array(
            'hostspec' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
		);
		if(!$port){
			$this->connDetails["port"] = $port;
		}
		return $this;
	}

	/**
	* Sets fetchmode, according with MDB2 values. Default mode: assoc.
	* @param 	string 	$fetch 			fetchmode for SQL returns
	*									options available:
	*									assoc:
	*										array with keys as the column names
	*									object:
	*										object with columns as properties
	*									if anything different from those values is sent, "assoc" is used
	* @return  	itself
	*/	
	public function SetFetchMode($fetch){
		switch($fetch){
			case "object":
			$this->fetchmode = self::FETCH_OBJECT;
			break;
			case "assoc":
			default:
			$this->fetchmode = self::FETCH_ASSOC;
			break;
		}
		return $this;
	}

	/**
	* Open connection, please. Please! 0=)
	* @return 	boolean		true or false, if connection succedded
	* @throws	MagratheaDbException
	*/
	public function OpenConnectionPlease(){
		return $this->Simulate("OpenConnection", "mysqli_connect()", $this->connDetails);
	}
	/**
	* Already uses you.. Bye.
	*/
	public function CloseConnectionThanks(){
		return $this->Simulate("closeConnection", "mysqli_close()", $this->connDetails);
	}
	
	/**
	* Handle connection errors @todo
	* @throws	MagratheaDbException
	*/
	private function ConnectionErrorHandle($msg="", $data){ 
		throw new MagratheaDBException($msg);
	}
	/**
	* Handle errors @todo
	* @throws	MagratheaDbException
	*/
	private function ErrorHandle($error, $sql, $values=null){ 
		$debug = "MagratheaDatabase ERROR => \n";
		$debug .= " query: [ ".$sql." ] \n";
		if($values != null)
			$debug .= " values: [ ".implode(',', $values)." ] \n";
		$debug .= " error: [ ".$error." ] \n";
		MagratheaDebugger::Instance()->Add($debug);
	}

	/**
	* Control Log
	* @param 	string 		$sql 		Query to be logged
	* @param 	object 		$values 	Values to be logged
	*/
	private function LogControl($sql, $values=null){
		MagratheaDebugger::Instance()->AddQuery($sql, $values);
	}


	/**
	 * Gets a mysqli result and returns an array with the rows, according to the selected fetch mode
	 * @param result  $result        result to be fetched
	 * @param boolean $firstLineOnly should we fetch all the result or do we need only the first line?
	 */
	private function FetchResult($result, $firstLineOnly=false){
		$arrResult = array();
		$isArrayResponse = false;
		switch($this->fetchmode){
			case self::FETCH_OBJECT:
				$fetch_fn = "fetch_object";
			break;
			case self::FETCH_NUM:
				$fetch_fn = "fetch_num";
				$isArrayResponse = true;
			break;
			case self::FETCH_ARRAY:
				$fetch_fn = "fetch_array";
				$isArrayResponse = true;
			break;
			case self::FETCH_ASSOC:
			default:
				$fetch_fn = "fetch_assoc";
				$isArrayResponse = true;
			break;
		}
		if($firstLineOnly){
			$arrResult = $result->$fetch_fn();
			if($isArrayResponse)
				$arrResult = array_change_key_case($arrResult, CASE_LOWER);
		}
		else 
			while( $obj = $result->$fetch_fn() ){
				if($isArrayResponse)
					$obj = array_change_key_case($obj, CASE_LOWER);
				array_push($arrResult, $obj);
			}
		return $arrResult;
	}


	// QUERY FUNCTIONS
	/**
	* executes the query and returns the full data
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	Result of the query
	*/
	public function Query($sql){
		$this->OpenConnectionPlease();
		$this->Simulate("query", $sql);
		$this->CloseConnectionThanks();
		return null;
	}
	
	/**
	* executes the query and returns the full data in an array
	* @param 	string 		$sql 		Query to be executed
	* @return 	array 		$result 	Result of the query (one row for line result)
	*/
	public function QueryAll($sql){
		$arrRetorno = array();
		$this->OpenConnectionPlease();
		$this->Simulate("query", $sql);
		$this->CloseConnectionThanks();
		return $arrRetorno;
	}
	
	/**
	* executes the query and returns only the first row of the result
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	First line of the query
	*/
	public function QueryRow($sql){
		$arrRetorno = array();
		$this->OpenConnectionPlease();
		$this->Simulate("query", $sql);
		$this->CloseConnectionThanks();
		return $arrRetorno;
	}
	
	/**
	* executes the query and returns only the first value of the first row of the result
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	First value of the first line
	*/
	public function QueryOne($sql){
		$this->OpenConnectionPlease();
		$this->Simulate("query", $sql);
		$this->CloseConnectionThanks();
		return null;
	}

	/**
	* receives an array of queries and executes them all
	*	@todo confirms if this is working properly
	* @param 	array 		$query_array  	Array of queries to be executed
	* @throws 	MagratheaDBException
	*/
	public function QueryTransaction($query_array){
		$this->OpenConnectionPlease();
		foreach( $query_array as $query ){
			$this->Simulate("query", $query);
		}
		$this->CloseConnectionThanks();
		return null;
	}
	
	/**
	* Prepares and execute a query and returns the inserted id (if any)
	* 	@todo validates types and avoids injection. Does it?
	* @param 	string 		$query 		Query to be executed
	* @param 	array 		$arrTypes 	Array of types from the values to be inserted
	* @param 	array 		$arrValues 	Array of values to be inserted
	*/
	public function PrepareAndExecute($query, $arrTypes, $arrValues){
		$this->LogControl($query, $arrValues);
		$this->OpenConnectionPlease();

		$params = "";
		if($arrTypes){
			foreach ($arrTypes as $type) {
				switch ($type) {
					case "int":
					case "boolean":
						$params .= "i";
						break;
					case "float":
						$params .= "d";
						break;
					case "datetime":
					case "text":
					case "string":
					default:
						$params .= "s";
						break;
				}
			}
		}

		$args = $arrValues;
		array_unshift($args, $params);
		try{
			$this->Simulate("PrepareAndExecute", $query, $args);
			$lastId = 42; // success!
		} catch(Exception $err){
			$this->ConnectionErrorHandle($err, $err);
		}
		$this->CloseConnectionThanks();
		if($lastId)
			return $lastId;
		else
			return true;
	}

	/**
	 * since PHP 5.3, it's necessary to pass values by reference in mysqli function to send them as args.
	 * Details can be found on @link http://php.net/manual/en/mysqli-stmt.bind-param.php
	 * @param  array 	$arr 	array to be "converted"
	 * @return array 	array as reference, ready to be used!
	 */
    private function makeValuesReferenced($arr){ 
        $refs = array(); 
        foreach($arr as &$val) 
        	array_push($refs, $val);
        return $refs; 
    } 
	
}
