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
* This class will provide a layer for connecting with mysql
* 
*/
class Magdb{

	const FETCH_ASSOC = 1;
	const FETCH_OBJECT = 2;

	private $mysqli;
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
	* @return 	Magdb 	Instance of the object
	*/
	public static function Instance(){
		if (self::$inst === null) {
			self::$inst = new Magdb();
		}
		return self::$inst;
	}
	
	/**
	* This is a singleton!
	* Should be called by private method Instance.
	* Don't implement new ones
	*/
	public function Magdb(){
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
	*/
	public function SetConnectionArray($dsn_arr){
		$this->connDetails = $dsn_arr;
	}
	/**
	* Setups connection
	* @param 	string 	$host 			host address for connection
	* @param 	string 	$database		database name
	* @param 	string 	$username 		username for connection
	* @param 	string 	$password		password for connection
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
	*/	
	public function SetFetchMode($fetch){
		switch($fetch){
			case "object":
			$this->fetchmode = @FETCH_OBJECT;
			break;
			case "assoc":
			default:
			$this->fetchmode = @FETCH_ASSOC;
			break;
		}
	}

	/**
	* Open connection, please. Please! 0=)
	* @return 	boolean		true or false, if connection succedded
	* @throws	MagratheaDbException
	*/
	public function OpenConnectionPlease(){
		try{
			if($this->connDetails["port"])
				$this->mysqli = new mysqli(
					$this->connDetails["hostspec"], 
					$this->connDetails["username"], 
					$this->connDetails["password"], 
					$this->connDetails["database"],
					$this->connDetails["port"]
				);
			else 
				$this->mysqli = new mysqli(
					$this->connDetails["hostspec"], 
					$this->connDetails["username"], 
					$this->connDetails["password"], 
					$this->connDetails["database"]
				);
			if($this->mysqli->connect_errno){
				throw new MagratheaDBException("Failed to connect to MySQL: (".$this->mysqli->connect_errno.") ".$this->mysqli->connect_error);
			}
		} catch (Exception $ex) {
			p_r($ex);
			throw new MagratheaDBException($ex->getMessage());
		}
		return true;
	}
	/**
	* Already uses you.. Bye.
	*/
	public function CloseConnectionThanks(){
		$this->mysqli->close();
	}
	
	/**
	* Handle connection errors @todo
	* @throws	MagratheaDbException
	*/
	private function ConnectionErrorHandle($msg="", $data){ 
		p_r($data);
		throw new MagratheaDBException($msg);
	}
	/**
	* Handle errors @todo
	* @throws	MagratheaDbException
	*/
	private function ErrorHandle($result, $sql){ 
		MagratheaLogger::Log(" ERROR!!! query error: [ ".$sql." ]");
		MagratheaLogger::LogError($result, "log_mysqlerror");
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
			case @FETCH_OBJECT:
				$fetch_fn = "fetch_object";
			break;
			case @FETCH_NUM:
				$fetch_fn = "fetch_num";
				$isArrayResponse = true;
			break;
			case @FETCH_ASSOC:
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
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mysqli->query($sql);
		if(is_object($result))
			$this->count = $result->num_rows;
		$this->CloseConnectionThanks();
		return $result;
	}
	
	/**
	* executes the query and returns the full data in an array
	* @param 	string 		$sql 		Query to be executed
	* @return 	array 		$result 	Result of the query (one row for line result)
	*/
	public function QueryAll($sql){
		$arrRetorno = array();
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mysqli->query($sql);
		if(!$result){
			$this->ErrorHandle($query);
		}
		if(is_object($result) ){
			$this->count = $result->num_rows;
			$arrRetorno = $this->FetchResult($result);
			$result->close();
		}
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
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mysqli->query($sql);
		$this->count = $result->num_rows;
		if($result){
			$arrRetorno = $this->FetchResult($result, true);
			$result->close();
		}
		$this->CloseConnectionThanks();
		return $arrRetorno;
	}
	
	/**
	* executes the query and returns only the first value of the first row of the result
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	First value of the first line
	*/
	public function QueryOne($sql){
		$retorno;
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mysqli->query($sql);
		$this->count = $result->num_rows;
		if($result){
			$retorno = $result->fetch_row();
			$result->close();
		}
		$this->CloseConnectionThanks();
		return $retorno[0];
	}

	/**
	* receives an array of queries and executes them all
	*	@todo confirms if this is working properly
	* @param 	array 		$query_array  	Array of queries to be executed
	* @throws 	MagratheaDBException
	*/
	public function QueryTransaction($query_array){
		$this->OpenConnectionPlease();

		$this->mysqli->autocommit(false);
		foreach( $query_array as $query ){
			$this->LogControl($query);
			$this->mysqli->query($query);
			if (!$mysqli->commit()) {
				$this->ErrorHandle(null, $query);
				return false;
			}
		}

		$this->CloseConnectionThanks();
		$this->mysqli->autocommit(true);
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

		$stm = $this->mysqli->prepare($query);
		if(!$stm || $this->mysqli->error ){
			$this->errorHandle(null, $query);
		}
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
			call_user_func_array(array($stm, "bind_param"),$this->makeValuesReferenced($args) );
			$stm->execute();
			if($stm->error) $this->ConnectionErrorHandle($stm->error);
			$lastId = $stm->insert_id;
			$stm->close();
		} catch(Exception $err){
			$this->ConnectionErrorHandle($err, $err);
		}
		$this->CloseConnectionThanks();
		return $lastId;
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
