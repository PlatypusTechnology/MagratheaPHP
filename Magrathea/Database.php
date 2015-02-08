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


require 'MDB2.php';

/**
* This class will provide a layer for connecting with mysql
* @deprecated 
*/
class Magdb_{
	private $mdb2;
	private $dsn = array();
	private $pear;
	private $fetchmode = MDB2_FETCHMODE_ASSOC;
	public $count = 0;
	protected static $inst = null;

	/**
	* This is a singleton!
	* Constructor is private
	*/
	private function __construct(){
		$this->pear = new PEAR();
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
	*						            'phptype'  => 'mysql',
	*						            'hostspec' => $host,
	*						            'database' => $database,
	*						            'username' => $username,
	*						            'password' => $password,
	*								);
	*/
	public function SetConnectionArray($dsn_arr){
		$this->dsn = $dsn_arr;
	}
	/**
	* Setups connection
	* @param 	string 	$host 			host address for connection
	* @param 	string 	$database		database name
	* @param 	string 	$username 		username for connection
	* @param 	string 	$password		password for connection
	*/	
	public function SetConnection($host, $database, $username, $password){
		$this->dsn = array(
            'phptype'  => 'mysql',
            'hostspec' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
		);
	}

	/**
	* Sets fetchmode, according with MDB2 values. Default mode: assoc.
	* @param 	string 	$fetch 			fetchmode for SQL returns
	*									options available:
	*									ordered:
	*										array with results ordered according with select statement
	*									assoc:
	*										array with keys as the column names
	*									object:
	*										object with columns as propertoies
	*									if anything different from those values is sent, "assoc" is used
	*/	
	public function SetFetchMode($fetch){
		switch($fetch){
			case "object":
			$this->fetchmode = DB_FETCHMODE_OBJECT;
			break;
			case "ordered":
			$this->fetchmode = MDB2_FETCHMODE_OBJECT;
			break;
			case "assoc":
			default:
			$this->fetchmode = MDB2_FETCHMODE_ASSOC;
			break;
		}
	}

	/**
	* Open connection, please. Please! 0=)
	* @return 	boolean		true or false, if connection succedded
	* @throws	MagratheaDbException
	*/
	public function OpenConnectionPlease(){
		$options['use_transactions'] = true;
		$options['default_table_type'] = 'InnoDB';
		try{
			$this->mdb2 = MDB2::factory($this->dsn, $options);
			if ($this->pear->isError($this->mdb2)) {
				$this->connectionErrorHandle("Could not connect to database!");
			}
			@$this->mdb2->setCharset("utf8");
			@$this->mdb2->setFetchMode($this->fetchmode);
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
		$this->mdb2->disconnect();
	}
	
	/**
	* Handle connection errors @todo
	* @throws	MagratheaDbException
	*/
	private function ConnectionErrorHandle($msg=""){ 
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

	// QUERY FUNCTIONS
	/**
	* executes the query and returns the full data
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	Result of the query
	*/
	public function Query($sql){
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mdb2->query($sql);
		if ($this->pear->isError($result)) {
			$this->errorHandle($result, $sql);
		}
		$this->count = @$result->numRows();
		$this->CloseConnectionThanks();
		return $result;
	}
	
	/**
	* executes the query and returns the full data in an array
	* @param 	string 		$sql 		Query to be executed
	* @return 	array 		$result 	Result of the query (one row for line result)
	*/
	public function QueryAll($sql){
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mdb2->queryAll($sql);
		p_r($result);
		if ($this->pear->isError($result)) {
			$this->ErrorHandle($result, $sql);
		}
		$this->CloseConnectionThanks();
		$this->count = count($result);
		return $result;
	}
	
	/**
	* executes the query and returns only the first row of the result
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	First line of the query
	*/
	public function QueryRow($sql){
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mdb2->queryRow($sql);
		if ($this->pear->isError($result)) {
			$this->errorHandle($result, $sql);
		}
		$this->CloseConnectionThanks();
		$this->count = 1;
		return $result;
	}
	
	/**
	* executes the query and returns only the first value of the first row of the result
	* @param 	string 		$sql 		Query to be executed
	* @return 	object 		$result 	First value of the first line
	*/
	public function QueryOne($sql){
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mdb2->queryOne($sql);
		if ($this->pear->isError($result)) {
			$this->errorHandle($result, $sql);
		}
		$this->CloseConnectionThanks();
		$this->count = 1;
		return $result;
	}

	/**
	* receives an array of queries and executes them all
	*	@todo confirms if this is working properly
	* @param 	array 		$query_array  	Array of queries to be executed
	* @throws 	MagratheaDBException
	*/
	public function QueryTransaction($query_array){
		$error = false;
		$this->OpenConnectionPlease();
		if (!$this->mdb2->supports('transactions')) {
			throw new MagratheaDBException("transactions not supported! why?");
		}

		$res = $this->mdb2->beginTransaction();
		foreach( $query_array as $query ){
			$this->LogControl($query);
			if( $error ) break;
			$result = $this->mdb2->query($query);
			if ($this->pear->isError($result)) {
				$error = true;
				$this->ErrorHandle(null, $query);
			}
		}

		if ($error) {
			$res = $this->mdb2->rollback();
		} else {
			$res = $this->mdb2->commit();
		}

		$this->CloseConnectionThanks();
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
		$sth = $this->mdb2->prepare($query, $arrTypes, MDB2_PREPARE_MANIP);
		$result = $sth->execute($arrValues);
		$lastId = $this->mdb2->lastInsertID();
		$sth->free();
		if ($this->pear->isError($result)) {
			$this->errorHandle($result, $query);
		}
		$this->CloseConnectionThanks();
		return $lastId;
	}
	
}
