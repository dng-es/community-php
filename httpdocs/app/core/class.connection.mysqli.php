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
	private $link;

	//class constructor
	public function __construct(){ }

	public function __get($name){
		if(defined("self::$name")) return constant("self::$name");
		trigger_error ("$name is not defined");
	}

	public static function conex(){
		//Database conection
		global $ini_conf;
		$link = mysqli_connect($ini_conf['host'], $ini_conf['user'], $ini_conf['pass'], $ini_conf['db']);
		mysqli_set_charset($link,'utf8');
		if (mysqli_connect_errno($link)) die(mysqli_connect_error());
		return $link;
	}

	public static function close_conex($cn){
		mysqli_close($cn);  
	}

	public static function execute_query($consulta){
		global $ini_conf;
		$link = self::conex();

		//debugger control
		if ((isset($ini_conf['debug_app']) && ($ini_conf['debug_app'] == 1 || $ini_conf['debug_app'] == 2)) && $consulta != ""){
			if (class_exists('debugger')) debugger::addError(0, $consulta, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql");
		}

		if ($da_query = mysqli_query($link, $consulta)){
			self::close_conex($link);
			return $da_query;
		}
		else{
			if ($ini_conf['debug_app'] == 1 || $ini_conf['debug_app'] == 2){
				debugger::addError(0, $consulta." - ".mysqli_error($link), $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error");
			}
			self::close_conex($link);
			return false;
		}
	}

	public static function get_result($result, $tipo = MYSQLI_ASSOC){
		try{
			return mysqli_fetch_array($result, $tipo);
		}
		catch (Exception $e){
			//echo 'Exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>