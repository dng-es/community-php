<?php
class rankings{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRankings($filter = ""){
		$Sql="SELECT r.*,c.ranking_category_name FROM users_tiendas_rankings r 
			LEFT JOIN users_tiendas_ranking_category c ON c.id_ranking_category=r.id_ranking_category WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}  

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRankingsCategoriesCount(){
		$Sql="SELECT c.id_ranking_category,c.ranking_category_name,COUNT(*) FROM `users_tiendas_rankings` r
		INNER JOIN `users_tiendas_ranking_category` c ON c.id_ranking_category=r.id_ranking_category
		WHERE r.activo=1
		GROUP BY ranking_category_name HAVING COUNT(r.id_ranking) ";
		return connection::getSQL($Sql);
	}     

	/**
	 * Inserta registro en rankings
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertRankings( $nombre_ranking, $descripcion_ranking, $activo=0, $id_ranking_category=0 ){		
		$Sql="INSERT INTO users_tiendas_rankings (nombre_ranking, descripcion_ranking, activo, id_ranking_category) 
			  VALUES ('".$nombre_ranking."','".$descripcion_ranking."',".$activo.",".$id_ranking_category.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Modifica estado rankings
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$value 		Nuevo estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateEstadoRankings($id, $value){
		$Sql="UPDATE users_tiendas_rankings SET
			 activo=".$value." 
			 WHERE id_ranking=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRankingsCategories($filter = ""){
		$Sql="SELECT * FROM users_tiendas_ranking_category WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}     

	/**
	 * Inserta registro en rankings
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertRankingsCategory( $nombre ){		
		$Sql="INSERT INTO users_tiendas_ranking_category (ranking_category_name) 
			  VALUES ('".$nombre."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Modifica estado rankings
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$nombre 	Nuevo estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateRankingsCategory($id, $nombre){
		$Sql="UPDATE users_tiendas_ranking_category SET
			 ranking_category_name='".$nombre."' 
			 WHERE id_ranking_category=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en rankings
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateRankings($id, $nombre_ranking, $descripcion_ranking, $id_ranking_category=0){
		$Sql="UPDATE users_tiendas_rankings SET
			 nombre_ranking='".$nombre_ranking."', 
			 descripcion_ranking='".$descripcion_ranking."', 
			 id_ranking_category='".$id_ranking_category."' 
			 WHERE id_ranking=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta registro en rankings
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertRankingsData( $id_ranking, $cod_tienda, $value_ranking ){		
		$Sql="INSERT INTO users_tiendas_rankings_data (id_ranking, cod_tienda, value_ranking) 
			  VALUES (".$id_ranking.",'".$cod_tienda."','".$value_ranking."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta registro en rankings
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteRankingsData( $filtro ){		
		$Sql="DELETE FROM users_tiendas_rankings_data 
				WHERE ".$filtro;
		return connection::execute_query($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRankingsData($filter = ""){
		$Sql="SELECT * FROM users_tiendas_rankings_data d 
				LEFT JOIN users_tiendas t ON t.cod_tienda=d.cod_tienda 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getRankingsDataSimple($filter = ""){
		$Sql="SELECT cod_tienda, value_ranking FROM users_tiendas_rankings_data 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 	

	public static function posicionRankingEmpresa($cod_tienda, $id_ranking){
		$Sql="SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
			(SELECT * FROM users_tiendas_rankings_data WHERE id_ranking=".$id_ranking." AND  value_ranking>=
			(SELECT value_ranking FROM users_tiendas_rankings_data WHERE id_ranking=".$id_ranking." AND cod_tienda='".$cod_tienda."') ORDER BY value_ranking DESC,cod_tienda ASC) r,  
			(SELECT @rownum:=0) ro ) f WHERE cod_tienda='".$cod_tienda."'";
		$result=connection::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=connection::get_result($result);
		return $row['rownum']; 
	} 
}
?>