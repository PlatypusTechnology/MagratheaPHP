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

class Magdb{
	private $mdb2;
	private $dsn = array();
	private $pear;
	private $fetchmode = MDB2_FETCHMODE_ASSOC;
	public $count = 0;
	protected static $inst = null;

	// this is a singleton!
	private function __construct(){
		$this->pear = new PEAR();
	}

	public static function Instance(){
		if (self::$inst === null) {
			self::$inst = new Magdb();
		}
		return self::$inst;
	}
	
	public function Magdb(){
	}
	public function SetConnectionArray($dsn_arr){
		$this->dsn = $dsn_arr;
	}
	public function SetConnection($host, $database, $username, $password){
		$this->dsn = array(
            'phptype'  => 'mysql',
            'hostspec' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
		);
	}
	// fetchmodes available: "ordered", "assoc", "object"
	// 	fetchmode default: assoc
	public function SetFetchMode($fetch){
		switch($fetch){
			case "object":
			case "ordered":
			$this->fetchmode = MDB2_FETCHMODE_OBJECT;
			break;
			case "assoc":
			default:
			$this->fetchmode = MDB2_FETCHMODE_ASSOC;
			break;
		}
	}

	public function OpenConnectionPlease(){
		$options['use_transactions'] = true;
		$options['default_table_type'] = 'InnoDB';
		try{
			$this->mdb2 = @MDB2::connect($this->dsn, $options);
			if ($this->pear->isError($this->mdb2)) {
				$this->connectionErrorHandle("Could not connect to database!");
			}
			@$this->mdb2->setCharset("utf8");
			@$this->mdb2->setFetchMode($this->fetchmode);
		} catch (Exception $ex) {
			throw new MagratheaDBException($ex->getMessage());
		}
		return true;
	}
	public function CloseConnectionThanks(){
		$this->mdb2->disconnect();
	}
	
	// TODO:
	private function ConnectionErrorHandle($msg=""){ 
		throw new MagratheaDBException($msg);
	}
	// TODO: 
	private function ErrorHandle($result, $sql){ 
		MagratheaLogger::Log(" ERROR!!! query error: [ ".$sql." ]");
		MagratheaLogger::LogError($result, "log_mysqlerror");
	}


	private function LogControl($sql, $values=null){
		MagratheaDebugger::Instance()->AddQuery($sql, $values);
	}

	// QUERY FUNCTIONS
	// executes the query and returns the data
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
	
	// executes the query and returns the data in an array
	public function QueryAll($sql){
		$this->LogControl($sql);
		$this->OpenConnectionPlease();
		$result = $this->mdb2->queryAll($sql);
		if ($this->pear->isError($result)) {
			$this->ErrorHandle($result, $sql);
		}
		$this->CloseConnectionThanks();
		$this->count = count($result);
		return $result;
	}
	
	// executes the query and returns the first row of the result (as an array)
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
	
	// executes the query and returns the first column from the first row
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

	// executes multiples queries with a rollback option
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
	
	// prepare data, insert it and returns the last insert id
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
