<?php

class promociones{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getPromociones($filter = ""){
		$Sql="SELECT * FROM promociones WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en promociones
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertPromociones($nombre_promocion, $texto_promocion, $active, $galeria_videos, $galeria_fotos, $galeria_comentarios){
		$Sql="INSERT INTO promociones(nombre_promocion,texto_promocion,active,galeria_videos,galeria_fotos,galeria_comentarios)
				VALUES
				('".$nombre_promocion."','".$texto_promocion."',".$active.",".$galeria_videos.",".$galeria_fotos.",".$galeria_comentarios.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en promociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deletePromociones($id){
		$Sql="DELETE FROM promociones WHERE id_promociones=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en promociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updatePromociones($id, $nombre_promocion, $texto_promocion, $galeria_videos, $galeria_fotos, $galeria_comentarios){
		$Sql="UPDATE promociones SET
			 nombre_promocion='".$nombre_promocion."', 
			 texto_promocion='".$texto_promocion."', 
			 galeria_videos=".$galeria_videos.", 
			 galeria_fotos=".$galeria_fotos.", 
			 galeria_comentarios=".$galeria_comentarios."  
			 WHERE id_promocion=".$id; //echo $Sql;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en promociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateActive($id, $value){
		$Sql="UPDATE promociones SET
			 active=".$value." 
			 WHERE id_promocion=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en promociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateActiveTodos($value, $filter){
		$Sql="UPDATE promociones SET
			 active=".$value." 
			 WHERE 1=1 ".$filter;
		return connection::execute_query($Sql);
	}	
}
?>