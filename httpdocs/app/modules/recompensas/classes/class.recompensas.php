<?php

class recompensas{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRecompensas($filter = ""){
		$Sql="SELECT * FROM recompensas WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en recompensas
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertRecompensas( ){		
		$Sql="INSERT INTO recompensas ( ) 
			  VALUES ()";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en recompensas
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteRecompensas($id){
		$Sql="DELETE FROM recompensas WHERE id_recompensas=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en recompensas
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateRecompensas($id,$value){
		$Sql="UPDATE recompensas SET
			 field='".$value."',
			 WHERE id_recompensas=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRecompensasUserList($filter = ""){
		$Sql="SELECT u.*,r.recompensa_name,r.recompensa_image
			FROM recompensas_user u 
			LEFT JOIN recompensas r ON r.id_recompensa=u.id_recompensa
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRecompensasUser($filter = ""){
		$Sql="SELECT u.*,r.recompensa_name,r.recompensa_image, COUNT(u.id_recompensa) AS total
			FROM recompensas_user u 
			LEFT JOIN recompensas r ON r.id_recompensa=u.id_recompensa
			WHERE 1=1 ".$filter." 
			GROUP BY recompensa_user,id_recompensa 
			ORDER BY recompensa_name"; //echo $Sql;
		return connection::getSQL($Sql);
	}  	

	/**
	 * Inserta registro en recompensas
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertRecompensaUser($id_recompensa, $recompensa_user, $recompensa_assign){		
		$Sql="INSERT INTO recompensas_user (id_recompensa, recompensa_user, recompensa_assign) 
			  VALUES (".$id_recompensa.",'".$recompensa_user."','".$recompensa_assign."')"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en recompensas
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteRecompensaUser($id){
		$Sql="DELETE FROM recompensas_user WHERE id_recompensas_user=".$id;
		return connection::execute_query($Sql);
	}
}
?>