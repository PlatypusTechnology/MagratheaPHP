<?php

require ("admin_load.php");

$object_name = $_POST["object"];
$obj = getObject($object_name);

//p_r($obj);

$createSql = " CREATE TABLE IF NOT EXISTS `".$obj["table_name"]."` ( \n";
// PK
$createSql .= "\t`".$obj["db_pk"]."` int(11) unsigned NOT NULL AUTO_INCREMENT, \n";

foreach($obj as $key => $item){
	if( substr($key, -6) == "_alias" ){
		$field_name = substr($key, 0, -6);
		if($field_name == $obj["db_pk"]) continue;
		if( $field_name == "created_at" || $field_name == "updated_at" ){
			$createSql .= "\t`".$field_name."` timestamp NOT NULL, \n";
			continue;
		}
		$type = "";
		switch ($obj[$field_name."_type"]) {
			case 'int':
				$type = "int(11)";
				break;
			case 'datetime':
				$type = "datetime";
				break;
			case 'text':
				$type = "text";
				break;
			case 'float':
				$type = "float";
				break;
			case 'string':
			default:
				$type = "varchar(255)";
				break;
		}
		$createSql .= "\t`".$field_name."` ".$type.", \n";
	}
}


$createSql .= "\tPRIMARY KEY (`".$obj["db_pk"]."`)\n";
$createSql .= "\n) DEFAULT CHARSET=utf8 ;";
$createSql .= "\n\n";

/*
// UPDATE v. 1.5: removing triggers
$createSql .= "DROP TRIGGER IF EXISTS `".$obj["table_name"]."_create`;\n";
$createSql .= "DROP TRIGGER IF EXISTS `".$obj["table_name"]."_update`;\n";
$createSql .= "CREATE TRIGGER `".$obj["table_name"]."_create` BEFORE INSERT ON `".$obj["table_name"]."` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW();\n";
$createSql .= "CREATE TRIGGER `".$obj["table_name"]."_update` BEFORE UPDATE ON `".$obj["table_name"]."` FOR EACH ROW SET NEW.updated_at = NOW();\n";
*/

$createSql .= "\n\n";


$query = "SHOW INDEX FROM ".$obj["table_name"];
$indexes = $magdb->queryAll($query);
$addIndexes = array();
foreach ($indexes as $i) {
	if( $i["key_name"] == "PRIMARY" ) continue;
	else if( $i["non_unique"] == 0 ) array_push($addIndexes, "ADD UNIQUE INDEX(`".$i["column_name"]."`)");
	else if( $i["index_type"] == "FULLTEXT" ) array_push($addIndexes, "ADD FULLTEXT(`".$i["column_name"]."`)");
	else array_push($addIndexes, "ADD INDEX(`".$i["column_name"]."`)");
}
if(count($addIndexes) > 0){
	$createSql .= "ALTER TABLE `".$obj["table_name"]."`\n";
	$createSql .= implode(",\n", $addIndexes).";";
	$createSql .= "\n\n";
}


die($createSql);

/*
CREATE TABLE `empresas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(255) NOT NULL DEFAULT '',
  `razao_social` varchar(255) DEFAULT NULL,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `telefone` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
*/



?>