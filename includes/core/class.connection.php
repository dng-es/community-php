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
	public function SelectMaxReg($campo,$tabla,$filter){	
	    global $ini_conf;
	    $Sql = "SELECT IFNULL(max(".$campo."),0) AS max_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		$result = self::execute_query($Sql) or die (($ini_conf['debug_app']==1 or $ini_conf['debug_app']==2) ? debugger::addError(0, $Sql, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error") : "");
		$row = self::get_result($result);
		return $row['max_counter'];
    }
	public function countReg($tabla,$filter){
	    global $ini_conf;
	    $Sql="SELECT count(*) AS table_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		$result = self::execute_query($Sql) or die (($ini_conf['debug_app']==1 or $ini_conf['debug_app']==2) ? debugger::addError(0, $Sql, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error") : "");
		$row = self::get_result($result);
		return $row['table_counter'];
    }

	public function timeServer(){
		global $ini_conf;
	    $Sql = "SELECT NOW() AS ahora";
		$result = self::execute_query($Sql) or die (($ini_conf['debug_app']==1 or $ini_conf['debug_app']==2) ? debugger::addError(0, $Sql, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error") : "");
		$row = self::get_result($result);
		return $row['ahora'];
    }

    public function getSQL($Sql){
		$result = self::execute_query($Sql);	
		$registros = array();  
		while ($registro = self::get_result($result)){  
		  $registros[] = $registro;  
		}
		return $registros;  
    }

    public static function executeSQL($Sql){
		if (self::execute_query($Sql)){ return true;}
		else { return false;}    	
    }
}
?>