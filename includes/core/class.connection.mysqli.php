<?php
///////////////////////////////////////////////////////////////////////////////////
// Author: David Noguera Gutierrez
// License: GPL
// Date: 2010-06-03
// Description: framework_da core class. Database conection and common functions.
// Please don't remove these lines
///////////////////////////////////////////////////////////////////////////////////

class connection_sql {
	const frameworkVersion=0.5;
	//class constructor
	public function __construct(){ }
	public function __get($name) {
		if(defined("self::$name")) { return constant("self::$name");}
		trigger_error ("$name is not defined");
	}
	
	public function conex(){
		//Database conection
		global $ini_conf;
		$link = mysqli_connect($ini_conf['host'],$ini_conf['user'],$ini_conf['pass'],$ini_conf['db']);
		if (mysqli_connect_errno($link)){
			die(mysqli_connect_error());
		}
		return $link;
	}

	public function close_conex($cn) {
		mysqli_close($cn);  
	}
	
	public function execute_query($consulta){
		global $ini_conf;
		$link=self::conex();
		mysqli_set_charset($link,'utf8');

		//debugger control		
		if ((isset($ini_conf['debug_app']) and ($ini_conf['debug_app']==1 or $ini_conf['debug_app']==2)) and $consulta!="") {
			if (class_exists('debugger')) {
				debugger::addError(0, $consulta, $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql");
			}
		}
		
		if ($da_query = mysqli_query($link, $consulta)) {
			self::close_conex($link);
			return $da_query;  
		}
		else {	
			if ($ini_conf['debug_app']==1 or $ini_conf['debug_app']==2) {
				debugger::addError(0, $consulta." - <b>".mysqli_error($link)."</b>", $_SERVER['SCRIPT_FILENAME'], 0, null, null, "sql_error");
			}
			self::close_conex($link);
			return false;
		}  
	}
	   
	public function get_result($result, $tipo = MYSQLI_ASSOC) {  
		try {
			return mysqli_fetch_array($result, $tipo); 
		} catch (Exception $e) {
			//echo 'Exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>