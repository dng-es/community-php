<?php
class batallas{
	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getBatallas($filter = ""){
		$Sql = "SELECT * FROM batallas b WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Inserta registro en batallas
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertBatalla($user_create, $user_retado, $tipo_batalla, $puntos, $canal_batalla){
		$Sql = "INSERT INTO batallas (user_create,user_retado,tipo_batalla,puntos,canal_batalla) 
					VALUES ('".$user_create."','".$user_retado."','".$tipo_batalla."', ".$puntos.",'".$canal_batalla."')"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	/**
	 * Obtiene las preguntas de las batallas
	 * @param  string 	$filter 	Filtro Sql
	 * @return array         		Array con los registros
	 */
	public function getBatallasPreguntas($filter = ""){
		$Sql = "SELECT * 
				FROM batallas_preguntas  
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve las preguntas y respuestas para una batalla
	 * @param  int 		$id_batalla Id de la batalla a recuperar datos
	 * @param  string 	$username   Usuario del que se quieren recuperar datos de la batallla
	 * @return array             	Array con registros
	 */
	public function getBatallaRespuestasPreguntas($id_batalla, $username){
		$Sql = "SELECT p.id_pregunta,p.pregunta, p.respuesta1, p.respuesta2, p.respuesta3,p.valida, r.batalla_respuesta 
				FROM batallas_respuestas r 
				LEFT JOIN batallas_preguntas p ON p.id_pregunta=r.batalla_pregunta
				WHERE r.id_batalla=".$id_batalla." AND username_batalla='".$username."' ";
		return connection::getSQL($Sql);
	}

	/**
	 * Obtiene las batallas individuales (batallas_luchas)
	 * @param  string $filter 		Filtro Sql
	 * @return array         		Array con los registros
	 */
	public function getBatallasLuchas($filter = ""){
		$Sql = "SELECT * 
				FROM batallas_luchas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertBatallaRespuesta($id_batalla, $username_batalla, $batalla_pregunta, $respuesta){
		$Sql = "INSERT INTO batallas_respuestas (id_batalla,username_batalla,batalla_pregunta,batalla_respuesta) 
				VALUES (".$id_batalla.",'".$username_batalla."',".$batalla_pregunta.",'".$respuesta."')";
		return connection::execute_query($Sql);
	}

	public function updateBatallaRespuesta($id_batalla, $username_batalla, $batalla_pregunta, $respuesta){
		$Sql = "UPDATE batallas_respuestas SET batalla_respuesta='".$respuesta."' 
				WHERE id_batalla=".$id_batalla." AND username_batalla='".$username_batalla."' AND batalla_pregunta=".$batalla_pregunta." ";
		return connection::execute_query($Sql);
	}

	public function finalizarBatalla($id_batalla, $user_ganador){
		$Sql = "UPDATE batallas SET finalizada=1,
				ganador = '".$user_ganador."' 
				WHERE id_batalla=".$id_batalla;
		return connection::execute_query($Sql);
	}

	public function insertBatallaLucha($id_batalla, $user_lucha, $tiempo_lucha, $aciertos_lucha, $origen=3){
		if ($tiempo_lucha < 1) $aciertos_lucha = 0;
		$Sql = "INSERT INTO batallas_luchas (id_batalla,user_lucha,tiempo_lucha,aciertos_lucha,origen) 
				VALUES (".$id_batalla.",'".$user_lucha."',".$tiempo_lucha.",".$aciertos_lucha.",".$origen.")";
		return connection::execute_query($Sql);
	}

	public function updateBatallaLucha($id_batalla, $user_lucha, $tiempo_lucha, $aciertos_lucha){
		$Sql = "UPDATE batallas_luchas SET 
				tiempo_lucha=".$tiempo_lucha.",
				aciertos_lucha=".$aciertos_lucha. " 
				WHERE id_batalla=".$id_batalla." AND user_lucha='".$user_lucha."' ";
		return connection::execute_query($Sql);
	}

	public function updateBatallaGanador($id_batalla, $user){
		$Sql = "UPDATE batallas SET 
				ganador='".$user."',
				finalizada=1 
				WHERE id_batalla=".$id_batalla." ";
		return connection::execute_query($Sql);
	}

	public function getBatallaCategorias($filter = ""){
		$Sql = "SELECT DISTINCT(pregunta_tipo) AS categoria 
				FROM batallas_preguntas  
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function getBatallasRanking($filter = ""){
		$Sql = "SELECT ganador AS usuario,COUNT(finalizada) AS victorias FROM batallas
				WHERE finalizada=1 AND ganador<>''
				GROUP BY ganador
				HAVING COUNT(finalizada) 
				ORDER BY victorias DESC, ganador ASC
				LIMIT 10".$filter;
		return connection::getSQL($Sql);
	}

	public static function getBatallasRankingUser($username){
		$Sql = "SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
			(SELECT SUM(finalizada) AS victorias,ganador FROM batallas WHERE ganador<>'' GROUP BY ganador HAVING SUM(finalizada)>=
			(SELECT SUM(finalizada) FROM batallas WHERE ganador='".$username."') ORDER BY victorias DESC,ganador ASC) r,  
			(SELECT @rownum:=0) ro ) f WHERE ganador='".$username."'";
		$row = connection::getSQL($Sql);
		return $row['rownum'];
	}

	public static function deleteBatallasCaducadas(){
		$Sql = "DELETE FROM batallas WHERE finalizada=0 AND date_batalla<DATE_ADD(CURDATE(), INTERVAL -2 DAY) ";
		return connection::execute_query($Sql);
	}
}
?>