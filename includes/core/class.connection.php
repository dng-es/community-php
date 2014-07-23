<?php
///////////////////////////////////////////////////////////////////////////////////
// Author: David Noguera Gutierrez
// License: GPL
// Date: 2010-06-03
// Description: framework_da core class. Database conection and common functions.
// Please don't remove these lines
///////////////////////////////////////////////////////////////////////////////////
set_time_limit(0);
class connection {
	const frameworkVersion=0.5;
	//class constructor
	public function __construct(){ }
    public function __get($name) 
    {
	  if(defined("self::$name")) { return constant("self::$name");}
	  trigger_error ("$name is not defined");
    }
	
	public function conex()
	{
	  //Database conection
	  global $ini_conf;
	  if (!$link = mysql_connect($ini_conf['host'],$ini_conf['user'],$ini_conf['pass'])){ die(mysql_error());}
	  if (!mysql_select_db($ini_conf['db'],$link)){ die(mysql_error());}
	  return $link;
	}

	public function close_conex($cn)  
	{
	  mysql_close($cn);  
	}
	
	public function execute_query($consulta)  
	{
	  $link=self::conex();
	  mysql_set_charset('utf8',$link);
	  if ($da_query = mysql_query($consulta, $link)) {
		self::close_conex($link);
		return $da_query;  
	  }
	  else {
		global $ini_conf;
		if ($ini_conf['debug_app']==1)
		{
			$msg="<b>SQL ERROR in query:</b> ".$consulta."; <b>SQL ERROR description:</b> ".mysql_error($link);
			ErrorMsg($msg);
		}
		self::close_conex($link);
		return false;
	  }  
	}
	   
	public function get_result($result, $tipo = MYSQL_ASSOC)  
	{  
	  try {
		    return mysql_fetch_array($result, $tipo); 
		} catch (Exception $e) {
		    //echo 'Exception: ',  $e->getMessage(), "\n";
		} 
	} 

	public function SelectMaxReg($campo,$tabla,$filter){	
	    $Sql="SELECT IFNULL(max(".$campo."),0) AS max_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		$result=self::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=self::get_result($result);
		return $row['max_counter'];
    }
	public function countReg($tabla,$filter){
	    $Sql="SELECT count(*) AS table_counter FROM ".$tabla." WHERE 1=1 ".$filter;
		$result=self::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=self::get_result($result);
		return $row['table_counter'];
    }

	public function timeServer(){
	    $Sql="SELECT NOW() AS ahora";
		$result=self::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=self::get_result($result);
		return $row['ahora'];
    }

    public function getSQL($Sql){
		$result=self::execute_query($Sql);	
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