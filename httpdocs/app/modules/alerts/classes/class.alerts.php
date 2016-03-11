<?php

class alerts{
	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getAlerts($filter = ""){
		$Sql="SELECT * FROM alerts WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en alerts
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertAlerts($text_alert, $type_alert, $destination_alert, $user_post, $priority, $date_ini, $date_fin){		
		$Sql="INSERT INTO alerts (text_alert, type_alert, destination_alert, user_post, priority, date_ini, date_fin) 
			  VALUES ('".$text_alert."', '".$type_alert."', '".$destination_alert."', '".$user_post."', '".$priority."', '".$date_ini."', '".$date_fin."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en alerts
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteAlerts($id){
		$Sql="DELETE FROM alerts WHERE id_alerts=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en alerts
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateAlerts($id,$value){
		$Sql="UPDATE alerts SET
			 field='".$value."',
			 WHERE id_alerts=".$id;
		return connection::execute_query($Sql);
	}
}
?>