<?php

abstract class MagratheaModelControl{
	protected static $modelName;
	protected static $dbTable;

	/**
	 * Run a query and return a list of the objects
	 * @param 	string 	$sql 	query string
	 * @return  Array<Object> 	List of objects
	 */
	public static function RunQuery($sql){
		$magdb = MagratheaDatabase::Instance();
		$objects = array();
		$result = $magdb->queryAll($sql);
		foreach($result as $item){
			$splitResult = MagratheaQuery::SplitArrayResult($item);
			$new_object = new static::$modelName();
			if(count($splitResult) > 0)
				$item = $splitResult[$new_object->GetDbTable()];
			$new_object->LoadObjectFromTableRow($item);
			array_push($objects, $new_object);
		}
		return $objects;
	}
	/**
	 * Run a query and return the first object available
	 * @param 	string 	$sql 	query string
	 * @return  Object 	First object found
	 */
	public static function RunRow($sql){
		$magdb = MagratheaDatabase::Instance();
		$row = $magdb->QueryRow($sql);
		$new_object = null;
		if(!empty($row)){
			$splitResult = MagratheaQuery::SplitArrayResult($row);
			$new_object = new static::$modelName();
			if(count($splitResult) > 0)
				$row = $splitResult[$new_object->GetDbTable()];
			$new_object->LoadObjectFromTableRow($row);
		}
		return $new_object;
	}
	/**
	 * Runs a query and returns the result
	 * @param 	string 	$sql 	query string
	 * @return  resultRow		database result
	 */
	public static function QueryResult($sql){
		return MagratheaDatabase::Instance()->queryAll($sql);
	}
	/**
	 * Runs a query and returns the first row of result
	 * @param 	string 	$sql 	query string
	 * @return  resultRow		database result (first line)
	 */
	public static function QueryOne($sql){
		return MagratheaDatabase::Instance()->queryOne($sql);
	}

	/**
	 * Runs a Magrathea Query and returns a list of objects
	 * (calls Run function)
	 * @param 	MagratheaQuery  	$magQuery  		MagratheaQuery query
	 * @return  Array<Object> 		List of objects
	 */
	public static function RunMagQuery($magQuery){ 
		return self::Run($magQuery); 
	}

	/**
	 * Runs query with Pagination. 
	 * 	This way, is not necessary to worry about including pagination on Magrathea Query, this function can deal with it
	 * @param 	MagratheaQuery  	$magQuery 		MagratheaQuery query
	 * @param 	int  				&$total   		total of rows (it will be stored in this variable; it's a pointer!)
	 * @param 	integer 			$page     		page to get (0 = first)
	 * @param 	integer 			$limit    		quantity per page (20 = default)
	 * @return  Array<Object> 		List of objects
	 */
	public static function RunPagination($magQuery, &$total, $page=0, $limit=20){
		$total = self::QueryOne($magQuery->Count());
		$magQuery->Limit($limit)->Page($page);
		return self::Run($magQuery);
	}
	/**
	 * Runs a Magrathea Query and returns a list of objects
	 * @param 	MagratheaQuery  	$magQuery  		MagratheaQuery query
	 * @param 	boolean 			$onlyFirst 		returns all of it or only first row?
	 * @return  Array<Object> 		List of objects
	 */
	public static function Run($magQuery, $onlyFirst=false){
		$array_joins = $magQuery->GetJoins();
		$arrayObjs = array();

		if(count($array_joins) > 0){
			$objects = array();
			$result = static::QueryResult($magQuery->SQL());
			foreach ($result as $r) {
				$splitResult = MagratheaQuery::SplitArrayResult($r);
				$new_object = new static::$modelName();
				if(count($splitResult) > 0)
					$r = $splitResult[$new_object->GetDbTable()];
				$new_object->LoadObjectFromTableRow($r);
				foreach($array_joins as $join){
					$obj = $join["obj"];
					$obj->LoadObjectFromTableRow($splitResult[$obj->GetDbTable()]);
					$objname = get_class($obj);
					if($join["type"] == "has_many"){
						$objnameField = $objname."s";
						if( empty($arrayObjs[$new_object->GetID()]) )
							$arrayObjs[$new_object->GetID()] = array();
						if( empty($arrayObjs[$new_object->GetID()][$objnameField]) )
							$arrayObjs[$new_object->GetID()][$objnameField] = array();
						$objIndex = count($arrayObjs[$new_object->GetID()][$objnameField]);
						$arrayObjs[$new_object->GetID()][$objnameField][$objIndex] = clone $obj;
						$new_object->$objnameField = $arrayObjs[$new_object->GetID()][$objnameField];
					} else {
						$new_object->$objname = clone $obj;
					}
					unset($obj);
				}
				array_push($objects, clone $new_object);
			}
			if($onlyFirst){
				if(count($objects) > 0) return $objects[0];
			} else return $objects;
		} else {
			return $onlyFirst ? self::RunRow($magQuery->SQL()) : self::RunQuery($magQuery->SQL());
		}
	}

	/**
	 * Gets all from this object
	 * @return  Array<Object> 	List of objects
	 */
	public static function GetAll(){
		$sql = "SELECT * FROM ".static::$dbTable." ORDER BY created_at DESC";
		return static::RunQuery($sql);
	}

	/**
	 * Builds query with where clause
	 * @param 	string 			$whereSql 		where clause
	 * @return  Array<Object> 	List of objects
	 */
	public static function GetSimpleWhere($whereSql){
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql;
		return static::RunQuery($sql);
	}

	/**
	 * Builds query with where clause
	 * @param 	string or array 	$arr 		where clause
	 * @param 	string 				$condition 	"AND" or "OR" for multiple clauses
	 * @return  Array<Object> 		List of objects
	 */
	public static function GetWhere($arr, $condition = "AND"){
		if(!is_array($arr)){
			return static::GetSimpleWhere($arr);
		}
		$whereSql = MAgratheaQuery::BuildWhere($arr, $condition);
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql." ORDER BY created_at DESC";
		return static::RunQuery($sql);
	}

	/**
	 * Builds query with where clause, returning only first row
	 * @param 	string or array 	$arr 		where clause
	 * @param 	string 				$condition 	"AND" or "OR" for multiple clauses
	 * @return  Object 				First object available
	 */
	public static function GetRowWhere($arr, $condition = "AND"){
		if(!is_array($arr)){
			return static::GetSimpleWhere($arr);
		}
		$whereSql = MagratheaQuery::BuildWhere($arr, $condition);
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql;
		return static::RunRow($sql);
	}

	/**
	 * This function allows to build a query getting multiple objects at once
	 * @param Array<objects> 	$array_objects Array of objects
	 * @param string 			$joinGlue      join string to be used on query
	 * @param string 			$where         Where clause
	 * @return  Array<Object> 		List of objects
	 */
	public static function GetMultipleObjects($array_objects, $joinGlue, $where=""){
		$magQuery = new MagratheaQuery();
		$magQuery->Table(static::$dbTable)->SelectArrObj($array_objects)->Join($joinGlue)->Where($where);

		// db:
		$objects = array();
		$result = MagratheaDatabase::Instance()->queryAll($magQuery->SQL());

		foreach($result as $item){
			// we have the result... but we have to separate it in the objects... shit, how can I do that?
			$splitResult = MagratheaQuery::SplitArrayResult($item);
			$itemArr = array();
			foreach ($array_objects as $key => $value) {
				$new_object = new $value();
				$new_object->LoadObjectFromTableRow($splitResult[$new_object->GetDbTable()]);
				$itemArr[$key] = $new_object;
			}
			array_push($objects, $itemArr);
		}
		return $objects;
	}

	/**
	 * Show all elements from an object
	 */
	public static function ShowAll(){
		$baseObj = new static::$modelName();
		$all = static::GetAll();
		$properties = $baseObj->GetProperties();
		echo "<table class='magratheaShowAll'>";
		echo "<tr>";
		foreach ($properties as $key => $value) {
			echo "<th>".$key." - (".$value.")</th>";
		}
		echo "</tr>";
		foreach ($all as $i) {
			echo "<tr>";
			foreach ($properties as $key => $value) {
				echo "<td>".$i->$key."</td>";
			}
			echo "</tr>";
		}
		echo "</tr>";
		echo "</table>";
	}

}

?>