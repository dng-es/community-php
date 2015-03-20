<?php
set_time_limit(0);
global $ini_conf;
$base_dir_config = realpath(dirname(__FILE__)) ;
$conector = (isset($ini_conf['sql_connector']) ? $ini_conf['sql_connector'] : "mysqli");
include ($base_dir_config."/class.connection.".$conector.".php");

class connection extends connection_sql{
	
	/**
	 * Select max value from a given field in a specific table
	 * @param string 		$field  		Field to get max value
	 * @param string 		$table  		BBDD table
	 * @param string 		$filter 		filter to apply
	 * @return int 							Max value
	 */
	public static function SelectMaxReg($field, $table, $filter){	
		$Sql = "SELECT IFNULL(max(".$field."),0) AS max_counter FROM ".$table." WHERE 1=1 ".$filter;
		if (($result = self::execute_query($Sql)) !== false){
			$row = self::get_result($result);
			return $row['max_counter'];
		}
	}

	/**
	 * Get number of records in a table with a filter applied
	 * @param  string 		$table  		Table name
	 * @param  string 		$filter 		Filter to apply
	 * @return int 							Number of records
	 */
	public static function countReg($table, $filter){
		$Sql="SELECT count(*) AS table_counter FROM ".$table." WHERE 1=1 ".$filter;
		if (($result = self::execute_query($Sql)) !== false){
			$row = self::get_result($result);
			return $row['table_counter'];
		}	
	}

	/**
	 * Get the sum of records in a table with a filter applied
	 * @param  string 		$table  		Table name
	 * @param  string 		$filter 		Filter to apply
	 * @return int 							Number of records
	 */
	public static function sumReg($table, $field, $filter){
		$Sql="SELECT IFNULL(sum(".$field."), 0) AS table_sum FROM ".$table." WHERE 1=1 ".$filter;
		if (($result = self::execute_query($Sql)) !== false){
			$row = self::get_result($result);
			return $row['table_sum'];
		}	
	}	

	/**
	 * Get date-time from server
	 * @return date Server date-time
	 */
	public static function timeServer(){
		$Sql = "SELECT NOW() AS ahora";
		if (($result = self::execute_query($Sql)) !== false){
			$row = self::get_result($result);
			return $row['ahora'];
		}
	}

	/**
	 * Get SQl result
	 * @param  string $Sql SQL query
	 * @return array      SQL query result
	 */
	public static function getSQL($Sql){
		$result = self::execute_query($Sql);	
		$registros = array();  
		while ($registro = self::get_result($result)){  
		  $registros[] = $registro;  
		}
		return $registros;  
	}
}
?>