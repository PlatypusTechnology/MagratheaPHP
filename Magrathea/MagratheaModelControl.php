<?php

abstract class MagratheaModelControl{
	protected static $modelName;
	protected static $dbTable;

	public static function RunQuery($sql){
		$magdb = Magdb::Instance();
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
	public static function RunRow($sql){
		$magdb = Magdb::Instance();
		$row = $magdb->QueryRow($sql);
		$new_object = null;
		if(!empty($row)){
			$new_object = new static::$modelName();
			$new_object->LoadObjectFromTableRow($row);
		}
		return $new_object;
	}
	public static function QueryResult($sql){
		return Magdb::Instance()->queryAll($sql);
	}
	public static function QueryOne($sql){
		return Magdb::Instance()->queryOne($sql);
	}


	public static function RunMagQuery($magQuery){ 
		return self::Run($magQuery); 
	}

	public static function RunPagination($magQuery, &$total, $page=0, $limit=20){
		$total = self::QueryOne($magQuery->Count());
		$magQuery->Limit($limit)->Page($page);
		return self::Run($magQuery);
	}

	public static function Run($magQuery){
		$array_obj = $magQuery->GetObjArray();
		if(count($array_obj) > 0){
			$objects = array();
			$result = static::QueryResult($magQuery->SQL());
			foreach ($result as $r) {
				$splitResult = MagratheaQuery::SplitArrayResult($r);
				$new_object = new static::$modelName();
				if(count($splitResult) > 0)
					$r = $splitResult[$new_object->GetDbTable()];
				$new_object->LoadObjectFromTableRow($r);
				foreach($array_obj as $obj){
					$obj->LoadObjectFromTableRow($splitResult[$obj->GetDbTable()]);
					$objname = get_class($obj);
					$new_object->$objname = clone $obj;
					unset($obj);
				}
				array_push($objects, clone $new_object);
			}
			return $objects;
		} else {
			return static::RunQuery($magQuery->SQL());
		}
	}

	public static function GetAll(){
		$sql = "SELECT * FROM ".static::$dbTable." ORDER BY created_at DESC";
		return static::RunQuery($sql);
	}

	public static function GetSimpleWhere($whereSql){
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql;
		return static::RunQuery($sql);
	}

	public static function GetWhere($arr, $condition = "AND"){
		if(!is_array($arr)){
			return static::GetSimpleWhere($arr);
		}
		$whereSql = MAgratheaQuery::BuildWhere($arr, $condition);
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql." ORDER BY created_at DESC";
		return static::RunQuery($sql);
	}

	public static function GetRowWhere($arr, $condition = "AND"){
		$whereSql = MagratheaQuery::BuildWhere($arr, $condition);
		$sql = "SELECT * FROM ".static::$dbTable." WHERE ".$whereSql;
		return static::RunRow($sql);
	}

	public static function GetMultipleObjects($array_objects, $joinGlue, $where=""){
		$magQuery = new MagratheaQuery();
		$magQuery->Table(static::$dbTable)->SelectArrObj($array_objects)->Join($joinGlue)->Where($where);

		// db:
		$objects = array();
		$result = Magdb::Instance()->queryAll($magQuery->SQL());

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