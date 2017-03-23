<?php

class incidencias{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncidencias($filter = ""){
		$Sql = "SELECT * FROM incidencias i 
			LEFT JOIN users u ON u.username=i.username_incidencia 
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncidenciasExport($filter = ""){
		$Sql = "SELECT i.*, u.name, u.surname, u.surname2, u.email,u.telefono FROM incidencias i 
			LEFT JOIN users u ON u.username=i.username_incidencia 
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncidenciasEstados($filter = ""){
		$Sql = "SELECT * FROM incidencias_estados WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   	

	/**
	 * Inserta registro en incidencias
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertIncidencias($username_incidencia, $texto_incidencia){
		$Sql = "INSERT INTO incidencias (username_incidencia, texto_incidencia) 
			  VALUES ('".$username_incidencia."', '".$texto_incidencia."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta registro en incidencias
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertIncidenciaEstado($id_incidencia, $username_estado_cambio, $estado_cambio){
		$Sql = "INSERT INTO incidencias_estados (id_incidencia, username_estado_cambio, estado_cambio) 
			  VALUES (".$id_incidencia.", '".$username_estado_cambio."', ".$estado_cambio.")";
		return connection::execute_query($Sql);
	}	

	/**
	 * Actualiza registro en incidencias
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateIncidencias($id, $username_incidencia, $texto_incidencia){
		$Sql = "UPDATE incidencias SET
			 texto_incidencia='".$texto_incidencia."'
			 WHERE id_incidencia=".$id." AND username_incidencia='".$username_incidencia."'";
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en incidencias
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function estadoIncidencia($id, $value, $filter = ""){
		$Sql = "UPDATE incidencias SET
			 estado_incidencia=".$value."
			 WHERE id_incidencia=".$id." ".$filter;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en incidencias
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateAdminIncidencias($id, $solucion_incidencia, $categoria_incidencia, $filter = ""){
		$Sql = "UPDATE incidencias SET
			 solucion_incidencia='".$solucion_incidencia."', 
			 categoria_incidencia='".$categoria_incidencia."' 
			 WHERE id_incidencia=".$id." ".$filter;
		return connection::execute_query($Sql);
	}	

		/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getCategorias($filter = ""){
		$Sql = "SELECT DISTINCT(categoria_incidencia) AS categoria FROM incidencias 
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}
}
?>