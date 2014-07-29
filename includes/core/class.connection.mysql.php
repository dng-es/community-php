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
		if (!$link = mysql_connect($ini_conf['host'],$ini_conf['user'],$ini_conf['pass'])){ die(mysql_error());}
		if (!mysql_select_db($ini_conf['db'],$link)){ die(mysql_error());}
		return $link;
	}

	public function close_conex($cn) {
		mysql_close($cn);  
	}
	
	public function execute_query($consulta){
		$link=self::conex();
		mysql_set_charset('utf8',$link);
		if ($da_query = mysql_query($consulta, $link)) {
			self::close_conex($link);
			return $da_query;  
		}
		else {
			global $ini_conf;
			if ($ini_conf['debug_app']==1) {
				$msg="<b>SQL ERROR in query:</b> ".$consulta."; <b>SQL ERROR description:</b> ".mysql_error($link);
				ErrorMsg($msg);
			}
			self::close_conex($link);
			return false;
		}  
	}
	   
	public function get_result($result, $tipo = MYSQL_ASSOC) {  
		try {
		    return mysql_fetch_array($result, $tipo); 
		} catch (Exception $e) {
		    //echo 'Exception: ',  $e->getMessage(), "\n";
		} 
	}   
}
?>