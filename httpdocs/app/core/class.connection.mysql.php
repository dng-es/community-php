<?php
/**
* @Database conection and common functions
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
* 
*/

class connection_sql {
	const frameworkVersion = 0.5;
	//class constructor
	public function __construct(){ }
	public function __get($name) {
		if(defined("self::$name")) { return constant("self::$name");}
		trigger_error ("$name is not defined");
	}
	
	public static function conex(){
		//Database conection
		global $ini_conf;
		if (!$link = mysql_connect($ini_conf['host'], $ini_conf['user'], $ini_conf['pass'])) die(mysql_error());
		if (!mysql_select_db($ini_conf['db'], $link)) die(mysql_error());
		mysql_set_charset('utf8',$link);
		return $link;
	}

	public static function close_conex($cn){
		mysql_close($cn);
	}

	public static function execute_query($consulta){
		global $ini_conf;
		$link = self::conex();

		//debugger control
		if ((isset($ini_conf['debug_app']) and ($ini_conf['debug_app'] == 1 or $ini_conf['debug_app'] == 2)) and $consulta != ""){
			if (class_exists('debugger')) debugger::addError(0, $consulta, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql");
		}

		if ($da_query = mysql_query($consulta, $link)){
			self::close_conex($link);
			return $da_query;
		}
		else{
			if ($ini_conf['debug_app'] == 1 or $ini_conf['debug_app'] == 2){
				debugger::addError(0, $consulta." - ".mysql_error($link), $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error");
			}
			self::close_conex($link);
			return false;
		}
	}

	public static function get_result($result, $tipo = MYSQL_ASSOC){
		try{
			return mysql_fetch_array($result, $tipo);
		}
		catch (Exception $e){
			//echo 'Exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>