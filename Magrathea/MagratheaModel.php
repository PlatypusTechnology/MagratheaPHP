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
	
	public function GetLazyLoad();

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
	
	public function GetDbTable(){ return $this->dbTable; }
	public function GetDbValues(){ return $this->dbValues; }
	public function GetProperties(){
		$properties = $this->dbValues;
		$properties["created_at"] = "datetime";
		$properties["updated_at"] = "datetime";
		return $properties;
	} 

	public function GetFieldsForSelect(){
		$fields = $this->dbValues;
		array_walk($fields, 'MagratheaQuery::BuildSelect', $this->dbTable);
		return implode(', ', $fields);
	}
	
	public function GetPkName(){
		return $this->dbPk;
	}
	public function GetID(){
		$pk = $this->dbPk;
		return $this->$pk;
	}
	
	public function GetLazyLoad(){
		return $this->autoLoad;
	}

	public function LoadObjectFromTableRow($row){
		foreach($row as $field => $value){
			$field = strtolower($field);
			if( property_exists($this, $field))
				$this->$field = $value;
		}
	}
	
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

	// Gets the next auto increment id for object:
	public function GetNextID(){
		$sql = "SHOW TABLE STATUS LIKE '".$this->dbTable."'";
		$data = MagratheaDatabase::Instance()->QueryRow($sql);
		return $data['auto_increment'];
	}

	/**
	 * Saves: Using a insert if pk is not set and an update if pk is set
	 * Basically, Inserts if id does not exists and updates if id does exists
	 * @return  id if inserted and true if updated
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
		MagratheaDatabase::Instance()->PrepareAndExecute($query_run, $arr_Types, $arr_Values);
		return true;
	}
	public function Delete(){
		$pkField = $this->dbPk;
		$arr_Types[$pkField] = $this->GetDataTypeFromField($this->dbValues[$pkField]);
		$arr_Values[$pkField] = $this->$pkField;
		// old query, for pear mdb2 driver
		// $query_run = "DELETE FROM ".$this->dbTable." WHERE ".$this->dbPk."=:".$this->dbPk;
		$query_run = "DELETE FROM ".$this->dbTable." WHERE ".$this->dbPk."= ? ";
		return MagratheaDatabase::Instance()->PrepareAndExecute($query_run, $arr_Types, $arr_Values);
	}

	public function __get($key){
		if( array_key_exists($key, $this->dbAlias) ){
			$real_key = $this->dbAlias[$key];
			return $this->$real_key;
		} else if( is_array($this->relations["properties"]) && array_key_exists($key, $this->relations["properties"]) ){
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
	 * Include all models presents on `Models` folder
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
