<?php

/**
* @Manage batallas
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0.1
*/
class batallas{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getBatallas($filter = ""){
		$Sql="SELECT * FROM batallas b WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Inserta registro en batallas
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertBatalla($user_create, $user_retado, $tipo_batalla, $puntos){		
		$Sql = "INSERT INTO batallas (user_create,user_retado,tipo_batalla,puntos) 
					VALUES ('".$user_create."','".$user_retado."','".$tipo_batalla."', ".$puntos.")"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	/**
	 * Obtiene las preguntas de las batallas
	 * @param  string 	$filter 	Filtro Sql
	 * @return array         		Array con los registros
	 */
	public function getBatallasPreguntas($filter = "")  {
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
	public function getBatallaRespuestasPreguntas($id_batalla, $username) {
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
 	public function getBatallasLuchas($filter = "") {
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

    public function finalizarBatalla($id_batalla,$user_ganador){
		$Sql = "UPDATE batallas SET finalizada=1,
				ganador = '".$user_ganador."'  
				WHERE id_batalla=".$id_batalla;

		return connection::execute_query($Sql);
    }       

    public function insertBatallaLucha($id_batalla,$user_lucha,$tiempo_lucha,$aciertos_lucha,$origen=3){
		if ($tiempo_lucha<1){$aciertos_lucha=0;}

		$Sql = "INSERT INTO batallas_luchas (id_batalla,user_lucha,tiempo_lucha,aciertos_lucha,origen) 
				VALUES (".$id_batalla.",'".$user_lucha."',".$tiempo_lucha.",".$aciertos_lucha.",".$origen.")";

		return connection::execute_query($Sql);
    }  

    public function updateBatallaLucha($id_batalla,$user_lucha,$tiempo_lucha,$aciertos_lucha){
		if ($tiempo_lucha<1){$aciertos_lucha=0;}
		$Sql = "update batallas_luchas SET 
				tiempo_lucha=".$tiempo_lucha.",
				aciertos_lucha=".$aciertos_lucha. " 
				WHERE id_batalla=".$id_batalla." AND user_lucha='".$user_lucha."' ";

		if (connection::execute_query($Sql)){ 
			//comprobar ganadores: obtener contrincantes de la batalla y verificar si han terminado la batalla.
			$batalla_datos = $this->getBatallas(" AND b.id_batalla=".$id_batalla);
			$creador = $batalla_datos[0]['user_create'];
			$oponente = $batalla_datos[0]['user_retado'];

			$partida_creador = $this->getBatallasLuchas(" AND id_batalla=".$id_batalla." AND user_lucha='".$creador."' ");
			$partida_oponente = $this->getBatallasLuchas(" AND id_batalla=".$id_batalla." AND user_lucha='".$oponente."' ");

			if (count($partida_creador)==1 and count($partida_oponente)==1){
				$partida_ganador = "";
				$partida_perdedor = "";
				//obtener ganador y perdedor
				if($partida_creador[0]['aciertos_lucha']==0 and $partida_oponente[0]['aciertos_lucha']==0){
					//ninguno ha acertado alguna respuesta: no hay ganador
					$partida_ganador = "";
					$partida_perdedor = "";
				}
				elseif($partida_creador[0]['aciertos_lucha'] > $partida_oponente[0]['aciertos_lucha']){
					$partida_ganador = $creador;
					$partida_perdedor = $oponente;
				}
				elseif($partida_creador[0]['aciertos_lucha'] < $partida_oponente[0]['aciertos_lucha']){
					$partida_ganador = $oponente;
					$partida_perdedor = $creador;					
				}
				else{
					//empate a aciertos, verificar tiempo
					if($partida_creador[0]['tiempo_lucha'] < $partida_oponente[0]['tiempo_lucha']){
					$partida_ganador = $creador;
					$partida_perdedor = $oponente;
					}
					elseif($partida_creador[0]['tiempo_lucha'] > $partida_oponente[0]['tiempo_lucha']){
						$partida_ganador = $oponente;
						$partida_perdedor = $creador;					
					}
				}
				
				//sumar y restar huellas. Verificar antes que la batalla no este finalizada
				$finalizada = connection::countReg("batallas"," AND id_batalla=".$id_batalla." AND finalizada=1 ");
				if ($finalizada == 0){
					if ($partida_ganador != "" and $partida_perdedor != ""){
						$users = new users();
						$users->sumarPuntos($partida_ganador,$batalla_datos[0]['puntos'],"ganador reto gamificacion");
						$users->sumarPuntos($partida_perdedor,-$batalla_datos[0]['puntos'],"perdedor reto gamificacion");
					}
					elseif ($partida_creador[0]['aciertos_lucha']==0 and $partida_oponente[0]['aciertos_lucha']==0){
						$users = new users();
						$users->sumarPuntos($creador,-$batalla_datos[0]['puntos'],"0 puntos reto gamificacion");
						$users->sumarPuntos($oponente,-$batalla_datos[0]['puntos'],"0 puntos reto gamificacion");
					}
				}

				//actualizar ganador
				$this->updateBatallaGanador($id_batalla,$partida_ganador);
			}
			return true;
		}
		else { return false;}
    }  

    public function updateBatallaGanador($id_batalla,$user){
		$Sql = "update batallas SET 
				ganador='".$user."',
				finalizada=1 
				WHERE id_batalla=".$id_batalla." ";

		return connection::execute_query($Sql);
    }           
    
    public function getBatallaCategorias($filter = "") {
	    $Sql = "SELECT DISTINCT(pregunta_tipo) AS categoria 
	    		FROM batallas_preguntas  
	    		WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql);  
	}	 

    public function getBatallasRanking($filter = "") {
	    $Sql = "SELECT ganador AS usuario,COUNT(finalizada) AS victorias FROM batallas
				WHERE finalizada=1 AND ganador<>''
				GROUP BY ganador
				HAVING COUNT(finalizada) 
				ORDER BY victorias DESC, ganador ASC
				LIMIT 10".$filter;
	    return connection::getSQL($Sql); 
	}

	public static function getBatallasRankingUser($username){
		$Sql="SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
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