<?php

class modelcolors{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getModelcolors($filter = ""){
		$Sql = "SELECT * FROM modelcolors WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en modelcolors
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertModelcolors( ){		
		$Sql = "INSERT INTO modelcolors ( ) 
			  VALUES ()";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en modelcolors
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteModelcolors($id){
		$Sql = "DELETE FROM modelcolors WHERE id_modelcolors=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en modelcolors
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateModelcolors($id, $value){
		$Sql = "UPDATE modelcolors SET
			 field='".$value."',
			 WHERE id_modelcolors=".$id;
		return connection::execute_query($Sql);
	}
}
?>