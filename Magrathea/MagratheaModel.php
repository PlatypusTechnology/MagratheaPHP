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
####	Model Class
####	Class and interface for model design
####	
####	created: 2012-12 by Paulo Martins
####
#######################################################################################

	
interface iMagratheaModel {
	public function __construct($id);
	
	public function Save();
	public function Insert();
	public function Update();
	public function GetID();
}
	
abstract class MagratheaModel{
	protected $dbTable;
	protected $autoLoad = null;
	protected $dbValues = array();
	protected $dbAlias = array();
	protected $relations = array();
	protected $dbPk;
	
	/**
	 * Gets table related to model
	 * @return 	string 		model's table
	 */
	public function GetDbTable(){ return $this->dbTable; }
	/**
	 * Gets array of table column values
	 * @return 	array 		model's columns
	 */
	public function GetDbValues(){ return $this->dbValues; }
	/**
	 * Get all properties from model
	 * @return 	array 		model's properties
	 */
	public function GetProperties(){
		$properties = $this->dbValues;
		$properties["created_at"] = "datetime";
		$properties["updated_at"] = "datetime";
		return $properties;
	} 

	/**
	 * Prepare fields for this model for a select statement
	 * @return 	string 		fields for select clause built
	 */
	public function GetFieldsForSelect(){
		$fields = $this->GetProperties();
		array_walk($fields, 'MagratheaQuery::BuildSelect', $this->dbTable);
		return implode(', ', $fields);
	}
	
	/**
	 * Gets PK Name
	 * @return 	string 		PK name column
	 */
	public function GetPkName(){
		return $this->dbPk;
	}
	/**
	 * Gets id value
	 * @return 	value 		Id value
	 */
	public function GetID(){
		$pk = $this->dbPk;
		return $this->$pk;
	}
	/**
	 * Gets autoload objects
	 * @return 	array 		auto load objects or null if none
	 */
	public function GetAutoLoad(){
		return $this->autoLoad;
	}

	/**
	 * Receives an array with the columns and values and associates then internally into the object
	 * @param 	array 		$row 		mysql result for the object
	 */
	public function LoadObjectFromTableRow($row){
		if(!is_array($row)) return;
		foreach($row as $field => $value){
			$field = strtolower($field);
			if( property_exists($this, $field))
				$this->$field = $value;
		}
	}
	
	/**
	 * Returns object by Id. If null, creates a null instance of the object.
	 * This will also load any related objects that are set as "autoload" internally.
	 * if an object with the given id can not be found, or any of the auto-load related objects can not be found an exception will be thrown.
	 * @param 	val 			$id 		id for the referred object
	 * @return 	object 			desired object
	 * @throws 	MagratheaModelException 	object could not be found
	 */
	public function GetById($id){
		if( empty($id) ) return null;
		if( $this->autoload && count($this->autoload) > 0 ) {
			$sql = MagratheaQuery::Select()->Table($this->dbTable)->SelectObj($this)->Where($this->dbTable.".".$this->dbPk." = ".$id);
			$tabs = array();
			foreach ($this->autoload as $objName => $relation) {
				$obj = new $objName();
				$sql->InnerObject($obj, $obj->dbTable.".".$obj->GetPkName()." = ".$this->dbTable.".".$relation);
				$tabs[$objName] = $obj->dbTable;
			}
			$result = MagratheaDatabase::Instance()->queryRow($sql->SQL());
			if( empty($result) ) throw new MagratheaModelException("Could not find ".get_class($this)." with id ".$id."!");

			$splitResult = MagratheaQuery::SplitArrayResult($result);
			$this->LoadObjectFromTableRow($splitResult[$this->GetDbTable()]);
			foreach ($tabs as $obj => $table) {
				$new_object = new $obj();
				$new_object->LoadObjectFromTableRow($splitResult[$new_object->GetDbTable()]);
				$this->$obj = $new_object;
			}
		} else {
			$sql = "SELECT * FROM ".$this->dbTable." WHERE ".$this->dbPk." = ".$id;
			$result = MagratheaDatabase::Instance()->queryRow($sql);
			if( empty($result) ) throw new MagratheaModelException("Could not find ".get_class($this)." with id ".$id."!");
			$this->LoadObjectFromTableRow($result);
		}
	}

	/**
	 * Gets the next auto increment id for this object
	 * @return  int 	next auto-increment value
	 */
	public function GetNextID(){
		$sql = "SHOW TABLE STATUS LIKE '".$this->dbTable."'";
		$data = MagratheaDatabase::Instance()->QueryRow($sql);
		return $data['auto_increment'];
	}

	/**
	 * Saves: Using a insert if pk is not set and an update if pk is set
	 * Basically, Inserts if id does not exists and updates if id does exists
	 * @return  int or boolean 		id if inserted and true if updated
	 */
	public function Save(){
		$pk = $this->dbPk;
		if( empty ($this->$pk ) )
			return $this->Insert();
		else
			return $this->Update();
	}
	/**
	 * Inserts the object in database
	 * @return 	int 		id of inserted object
	 * @todo  	create query to UPDATE in case of id already exists... (or deal with it with an exception)
	 */
	public function Insert(){
		$arr_Types = array();
		$arr_Fields = array();
		$arr_Values = array();
		foreach( $this->dbValues as $field => $type ){
			if( $field == $this->dbPk ){
				if(empty($this->$field)) continue;
			} 
			array_push($arr_Types, $this->GetDataTypeFromField($type));
			array_push($arr_Fields, $field);
			$arr_Values[$field] = $this->$field;
		}
		// old query, for pear mdb2 driver
		// $query_run = "INSERT INTO ".$this->dbTable." (".implode(",", $arr_Fields).") VALUES (:".implode(",:", $arr_Fields).") ";
		$query_run = "INSERT INTO ".$this->dbTable." (".implode(",", $arr_Fields).") VALUES (".implode(", ", array_fill(0, count($arr_Fields), "?")).") ";
		$lastId = MagratheaDatabase::Instance()->PrepareAndExecute($query_run, $arr_Types, $arr_Values);
		$pk = $this->dbPk;
		$this->$pk = $lastId;
		return $lastId;
	}
	/**
	 * Updates the object in database
	 * @return 	boolean	 		successfully updated
	 */
	public function Update(){
		$arr_Types = array();
		$arr_Fields = array();
		$arr_Values = array();
		$pkField = $this->dbPk;
		foreach( $this->dbValues as $field => $type ){
			if( $field == $pkField ) continue;
			$arr_Values[$field] = $this->$field;
			array_push($arr_Types, $this->GetDataTypeFromField($type));
			array_push($arr_Fields, $field."= ? ");
		}
		$query_run = "UPDATE ".$this->dbTable." SET ".implode(",", $arr_Fields)." WHERE ".$this->dbPk."= ? ";

		$arr_Values[$pkField] = $this->$pkField;
		$arr_Types[$pkField] = $this->GetDataTypeFromField($pkField);
		return MagratheaDatabase::Instance()->PrepareAndExecute($query_run, $arr_Types, $arr_Values);
	}
	/**
	 * Updates the object in database
	 * @return 	boolean	 		successfully updated
	 */
	public function Delete(){
		$pkField = $this->dbPk;
		$arr_Types[$pkField] = $this->GetDataTypeFromField($this->dbValues[$pkField]);
		$arr_Values[$pkField] = $this->$pkField;
		// old query, for pear mdb2 driver
		// $query_run = "DELETE FROM ".$this->dbTable." WHERE ".$this->dbPk."=:".$this->dbPk;
		$query_run = "DELETE FROM ".$this->dbTable." WHERE ".$this->dbPk."= ? ";
		return MagratheaDatabase::Instance()->PrepareAndExecute($query_run, $arr_Types, $arr_Values);
	}

	/**
	 * MAGIC FUNCTION: gets required property
	 * @param  	string 		$key 			property
	 * @return 	val      	property value
	 * @throws 	MagratheaModelException 	if property does not exists into object
	 */
	public function __get($key){
		if( array_key_exists($key, $this->dbAlias) ){
			$real_key = $this->dbAlias[$key];
			return $this->$real_key;
		} else if( @is_array($this->relations["properties"]) && array_key_exists($key, $this->relations["properties"]) ){
			if( is_null($this->relations["properties"][$key]) ){
				if( $this->relations["lazyload"][$key] ){
					$loadFunction = $this->relations["methods"][$key];
					$this->relations["properties"][$key] = $this->$loadFunction();
				}
			}
			return $this->relations["properties"][$key];
		} else {
			throw new MagratheaModelException("Property ".$key." does not exists in ".get_class($this)."!");
		}
	}
	
	/**
	 * MAGIC FUNCTION: updates required property
	 * @param  	string 		$key 			property
	 * @param  	object 		$value 			value
	 * @return 	object     	property value
	 * @throws 	MagratheaModelException 	if property does not exists into object
	 */
	public function __set($key, $value){
		if( $key == "created_at" || $key == "updated_at" ) return false;
		if( array_key_exists($key, $this->dbAlias) ){
			$real_key = $this->dbAlias[$key];
			$this->$real_key = $value;
		} else if( @is_array($this->relations["properties"]) && array_key_exists($key, $this->relations["properties"]) ){
			$method_set = $this->relations["methods"][$key];
 			$this->relations["properties"][$key] = $value;
		} else {
			throw new MagratheaModelException("Property ".$key." does not exists in ".get_class($this)."!");
		}
	}

	/**
	 * Get (Magrathea) data type from field
	 * @param 	string 		$field 		magrathea-related type
	 */
	public static function GetDataTypeFromField($field){
		switch($field){
			case "text":
			case "string":
				return "text";
			case "boolean":
			case "int":
			case "integer":
				return "integer";
			case "double":
			case "float":
				return "decimal";
			case "datetime":
				return "date";
		}
	}

	/**
	 * Include all classes presents on `Models` folder
	 */
	public static function IncludeAllModels(){
		$modelsFolder = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/Models";
		if($handle = @opendir($modelsFolder)){
			while (false !== ($file = readdir($handle))) {
				$filename = explode('.', $file);
				$ext = array_pop($filename);
				if(empty($ext)) continue;
				if($ext == "php"){
					include_once($modelsFolder."/".$file);
				}
			}
			closedir($handle);
		}
	}
	
	/**
	 * To String! =)
	 * @return 	string 		Object.toString()
	 */
	public function __toString(){
		$print_this = "Class ".get_class($this).":\n";
		$print_this .= count($this->dbValues > 0 ) ? "\tProperties\n" : "";
		foreach( $this->dbValues as $field => $type ){
			$print_this .= "\t\t[".$field."] (".$type.") = ".$this->$field."\n";
		}
		$print_this .= count($this->dbAlias>0) ? "\tAlias\n" : "";
		foreach( $this->dbAlias as $alias => $field ){ 
			$print_this .= "\t\t[".$alias."] (alias for ".$field.") = ".$this->$field."\n";
		}
		return "<pre>".$print_this."</pre>";
	}
	
}
