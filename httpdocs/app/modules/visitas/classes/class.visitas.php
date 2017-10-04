<?php
class visitas{
	public static function getVisitas($filter = ""){
		$Sql = "SELECT a.*,u.name,u.surname 
				FROM accesscontrol a 
				JOIN users u ON u.username=a.username 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function insertVisita($username, $ruta, $webpage_id, $perfil_access, $empresa_access, $canal_access){
		$Sql = "INSERT into accesscontrol (username,webpage,ip,agent,browser,platform, webpage_id, perfil_access, empresa_access, canal_access, webpage_origin) 
				VALUES ('".$username."','".$ruta."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".getBrowser($_SERVER['HTTP_USER_AGENT'])."','".getPlatform($_SERVER['HTTP_USER_AGENT'])."', '".$webpage_id."', '".$perfil_access."', '".$empresa_access."','".$canal_access."','".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "")."');";
		return connection::execute_query($Sql);
	}

	public static function updateVisitaSeconds($username){
		//tiempo de la ultima visita
		$id = connection::SelectMaxReg("id", "accesscontrol", " AND username='".$username."' AND webpage<>'Inicio sesion' ");
		$Sql = "UPDATE accesscontrol SET 
				seconds = (TIMESTAMPDIFF(SECOND, fecha, NOW())) 
				WHERE id=".$id;
		return connection::execute_query($Sql);
	}

	public static function deleteVisitas(){
		$Sql = "DELETE FROM accesscontrol";
		return connection::execute_query($Sql);
	}

	public static function getAccessPages($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS contador,DATE(fecha) AS fecha,YEAR(fecha) AS anio,MONTH(fecha) AS mes,DAY(fecha) AS dia 
				FROM accesscontrol 
				WHERE 1=1 ".$filter." 
				GROUP BY DATE(fecha) "; //echo $Sql."<br /><br />";
		return connection::getSQL($Sql);
	}

	public static function getAccessUnique($filter = ""){
		$Sql = "SELECT COUNT(*) AS contador,DATE(fecha) AS fecha,YEAR(fecha) AS anio,MONTH(fecha) AS mes,DAY(fecha) AS dia 
				FROM (
					SELECT username,fecha 
					FROM accesscontrol 
					WHERE 1=1 ".$filter." 
					GROUP BY username, DATE(fecha)) AS total
				GROUP BY DATE(fecha) "; //echo $Sql."<br /><br />";
		return connection::getSQL($Sql);
	}

	public static function getAccessHour($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS contador,HOUR(fecha) AS date_hour 
				FROM accesscontrol 
				WHERE 1=1 ".$filter." 
				GROUP BY HOUR(fecha) ";
		return connection::getSQL($Sql);
	}	

	public static function getAccessBrowser($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS contador,browser 
				FROM accesscontrol 
				WHERE 1=1 ".$filter." 
				GROUP BY browser ";
		return connection::getSQL($Sql);
	}

	public static function getAccessPlatform($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS contador,platform 
				FROM accesscontrol 
				WHERE 1=1 ".$filter." 
				GROUP BY platform ";
		return connection::getSQL($Sql);
	}

	public static function getAccessTopPages($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS contador,webpage 
				FROM accesscontrol 
				WHERE 1=1 ".$filter." 
				GROUP BY webpage ORDER BY webpage ";
		return connection::getSQL($Sql);
	}

	public static function getVisitasInformes($filter = ""){
		$Sql = "SELECT a.*,u.name,u.surname 
				FROM accesscontrol a 
				JOIN users u ON u.username=a.username 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function getAccessGroup($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS ".strTranslate('Visits_title').",empresa_access AS ".strTranslate('Group_user').",nombre_tienda AS ".strTranslate('Name')." 
				FROM accesscontrol a 
				INNER JOIN users_tiendas t ON t.cod_tienda=a.empresa_access 
				WHERE 1=1 AND empresa_access<>'' ".$filter." 
				GROUP BY empresa_access 
				ORDER BY ".strTranslate('Visits_title')." DESC,empresa_access"; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public static function getAccessNaAreas($filter = ""){
		$Sql = "SELECT COUNT(webpage) AS ".strTranslate('Visits_title').",area_nombre AS ".strTranslate('Na_areas').",webpage_id FROM accesscontrol a 
				INNER JOIN na_areas na ON na.id_area=a.webpage_id 
				WHERE 1=1 AND webpage='areas_det' ".$filter." 
				GROUP BY webpage_id 
				ORDER BY ".strTranslate('Visits_title')." DESC,".strTranslate('Na_areas')." "; //echo $Sql;
		return connection::getSQL($Sql);
	}	
}
?>