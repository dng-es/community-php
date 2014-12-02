<?php
///////////////////////////////////////////////////////////////////////////////////
// Author: David Noguera Gutierrez
// License: GPL
// Date: 2010-06-03
// Description: framework_da core class. Database conection and common functions.
// Please don't remove these lines
///////////////////////////////////////////////////////////////////////////////////
set_time_limit(0);
global $ini_conf;
$base_dir_config = realpath(dirname(__FILE__)) ;
$conector = (isset($ini_conf['sql_connector']) ? $ini_conf['sql_connector'] : "mysqli");
include ($base_dir_config."/class.connection.".$conector.".php");

class connection extends connection_sql{
	public static function SelectMaxReg($campo,$tabla,$filter){	
	    $Sql = "SELECT IFNULL(max(".$campo."),0) AS max_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		if (($result = self::execute_query($Sql))!==false){
			$row = self::get_result($result);
			return $row['max_counter'];
		}
    }
	public static function countReg($tabla,$filter){
	    $Sql="SELECT count(*) AS table_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		if (($result = self::execute_query($Sql))!==false){
			$row = self::get_result($result);
			return $row['table_counter'];
		}	
    }

	public static function timeServer(){
	    $Sql = "SELECT NOW() AS ahora";
		if (($result = self::execute_query($Sql))!==false){
			$row = self::get_result($result);
			return $row['ahora'];
		}
    }

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