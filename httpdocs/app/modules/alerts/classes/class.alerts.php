<?php
class alerts{
	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public static  function getAlerts($filter = ""){
		$Sql = "SELECT *
				FROM alerts a
				LEFT JOIN alerts_types t ON t.id_alert_type=a.id_alert_type
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Inserta registro en alerts
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertAlerts($title_alert, $text_alert, $type_alert, $destination_alert, $user_post, $priority, $date_ini, $date_fin, $id_alert_type, $time_ini, $time_fin, $nombre_archivo, $registro, $registro_limite){
		$Sql = "INSERT INTO alerts (title_alert, text_alert, type_alert, destination_alert, user_post, priority, date_ini, date_fin, id_alert_type, time_ini, time_fin, nombre_archivo,registro,registro_limite)
				VALUES ('".$title_alert."','".$text_alert."', '".$type_alert."', '".$destination_alert."', '".$user_post."', '".$priority."', '".$date_ini."', '".$date_fin."', ".$id_alert_type.", '".$time_ini."', '".$time_fin."', '".$nombre_archivo."',".$registro.",".$registro_limite.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en alerts
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateAlerts($id_alert,$title_alert, $text_alert, $type_alert, $destination_alert, $priority, $date_ini, $date_fin, $id_alert_type, $time_ini, $time_fin, $nombre_archivo, $registro, $registro_limite){
		$Sql = "UPDATE alerts SET
				title_alert='".$title_alert."',
				text_alert='".$text_alert."',
				type_alert='".$type_alert."',
				destination_alert='".$destination_alert."',
				priority='".$priority."',
				date_ini='".$date_ini."',
				date_fin='".$date_fin."',
				id_alert_type=".$id_alert_type.",
				time_ini='".$time_ini."',
				time_fin='".$time_fin."',
				nombre_archivo='".$nombre_archivo."',
				registro=".$registro.",
				registro_limite=".$registro_limite."
				WHERE id_alert=".$id_alert." "; //echo $Sql;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en alerts
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteAlerts($id){
		$Sql = "DELETE FROM alerts
				WHERE id_alerts=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Cambiar estado alertas
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public static function disableAlerts($id, $value = 0){
		$Sql = "UPDATE alerts SET
				activa=".$value."
				WHERE id_alert=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public static  function getAlertsTypes($filter = ""){
		$Sql = "SELECT *
				FROM alerts_types
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Cambiar estado alertas
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public static function disableAlertsTypes($id, $value = 0){
		$Sql = "UPDATE alerts_types SET
				estado_type=".$value."
				WHERE id_alert_type=".$id;
		return connection::execute_query($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public static  function getAlertsRegistro($filter = ""){
		$Sql = "SELECT *
				FROM alerts_inscripciones
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public static  function getAlertsRegistroExport($filter = ""){
		$Sql = "SELECT i.username, u.name, u.surname, u.empresa AS '".strTranslate("Group_user")."', i.id_alert, i.inscrito, i.date_inscripcion 
				FROM alerts_inscripciones i 
				LEFT JOIN alerts a ON a.id_alert=i.id_alert 
				LEFT JOIN users u ON u.username=i.username
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}	

	/**
	 * Cambiar estado alertas
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public static function insertAlertsRegistro($id_alert, $username, $inscrito){
		$Sql = "INSERT INTO alerts_inscripciones (id_alert, username, inscrito) VALUES(".$id_alert.", '".$username."', ".$inscrito.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en alerts
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateAlertsType($id_alert_type, $name_type, $color_type, $icon_type, $perfiles_type, $aprobacion){
		$Sql = "UPDATE alerts_types SET
				name_type='".$name_type."',
				color_type='".$color_type."',
				icon_type='".$icon_type."',
				perfiles_type='".$perfiles_type."',
				aprobacion=".$aprobacion."  
				WHERE id_alert_type=".$id_alert_type." "; //echo $Sql;
		return connection::execute_query($Sql);
	}	

	/**
	 * Inserta registro en alerts
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertAlertsType($name_type, $color_type, $icon_type, $perfiles_type, $aprobacion){
		$Sql = "INSERT INTO alerts_types (name_type, color_type, icon_type, perfiles_type, aprobacion)
				VALUES ('".$name_type."','".$color_type."', '".$icon_type."', '".$perfiles_type."', ".$aprobacion.")";
		return connection::execute_query($Sql);
	}		
}
?>