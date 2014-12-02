<?php
/**
* @Control de accesos e informes estadísticos
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*/	
class visitas{
	
	function getVisitas($filter = ""){
		$Sql="SELECT a.*,u.name,u.surname FROM accesscontrol a 
			  JOIN users u ON u.username=a.username WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}
	  
	public function insertVisitas($username,$ruta,$movil=0){
		$Sql = "insert into accesscontrol (username,webpage,movil,ip,agent,browser,platform) 
				values ('".$username."','".$ruta."',".$movil.",'".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".getBrowser($_SERVER['HTTP_USER_AGENT'])."','".getPlatform($_SERVER['HTTP_USER_AGENT'])."');";
		connection::execute_query($Sql);

		//puntuacion semanal
		if(connection::countReg("accesscontrol"," AND username='".$username."' AND WEEK(fecha)=WEEK(NOW()) AND YEAR(fecha)=YEAR(NOW())")==1){
		  users::sumarPuntos($username,PUNTOS_ACCESO_SEMANA,PUNTOS_ACCESO_SEMANA_MOTIVO);}
		  
		return true;
	}

	public function deleteVisitas(){
		$Sql="DELETE FROM accesscontrol";
		return connection::execute_query($Sql);
	}	 	 

	function getAccessPages($filter = ""){
		$Sql="SELECT COUNT(webpage) AS contador,DATE(fecha) AS fecha,YEAR(fecha) AS anio,MONTH(fecha) AS mes,DAY(fecha) AS dia FROM accesscontrol WHERE 1=1 ".$filter." GROUP BY DATE(fecha) ";
		return connection::getSQL($Sql);
	}

	function getAccessBrowser($filter = ""){
		$Sql="SELECT COUNT(webpage) AS contador,browser FROM accesscontrol WHERE 1=1 ".$filter." GROUP BY browser ";
		return connection::getSQL($Sql);
	}	  

	function getAccessPlatform($filter = ""){
		$Sql="SELECT COUNT(webpage) AS contador,platform FROM accesscontrol WHERE 1=1 ".$filter." GROUP BY platform ";
		return connection::getSQL($Sql);
	}	  	  

	function getAccessTopPages($filter = ""){
		$Sql="SELECT COUNT(webpage) AS contador,webpage FROM accesscontrol WHERE 1=1 ".$filter." GROUP BY webpage ORDER BY webpage ";
		return connection::getSQL($Sql);
	}

	function getVisitasInformes($filter = ""){
		$Sql="SELECT a.*,u.name,u.surname FROM accesscontrol a 
			  JOIN users u ON u.username=a.username WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}
}
?>