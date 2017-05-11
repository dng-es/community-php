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

		try {
			$link = new PDO("dblib:host=".$ini_conf['host'].";dbname=".$ini_conf['db'], $ini_conf['user'], $ini_conf['pass']); 
			return $link;
		} catch (PDOException $e) {
			echo 'Falló la conexión: ' . $e->getMessage();
		}
		

		//if ($link) return $link;
		//else die(sqlsrv_errors());
	
	}

	public static function close_conex($cn){
		$cn = null;
	}

	public static function execute_query($consulta){
		global $ini_conf;
		$link = self::conex();

		//debugger control
		if ((isset($ini_conf['debug_app']) && ($ini_conf['debug_app'] == 1 || $ini_conf['debug_app'] == 2)) && $consulta != ""){
			if (class_exists('debugger')) debugger::addError(0, $consulta, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql");
		}

		if ($da_query = $link->exec($consulta)){
			self::close_conex($link);
			return $da_query;
		}
		else{
			if ($ini_conf['debug_app'] == 1 || $ini_conf['debug_app'] == 2){
				//debugger::addError(0, $consulta." - ".sqlsrv_errors($link), $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error");
			}
			self::close_conex($link);
			return false;
		}
	}

	public static function get_result($result){
		try{
			return $result->fetch(PDO::FETCH_BOTH);
		}
		catch (Exception $e){
			echo 'Exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>