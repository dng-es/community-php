<?php
class cuestionarios{
	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getCuestionarios($filter = ""){
		$Sql = "SELECT * FROM cuestionarios WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Inserta registro en cuestionarios
	 * @return boolean 				Resultado de la SQL
	 */
	public function insertCuestionarios($nombre, $descripcion){
		$Sql = "INSERT INTO cuestionarios (nombre, descripcion) 
				VALUES ('".$nombre."', '".$descripcion."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en cuestionarios
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$activo 	Estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteCuestionarios($id, $activo){
		$Sql = "UPDATE cuestionarios SET activo=".$activo." WHERE id_cuestionario=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en cuestionarios
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  string	$value 		Nuevo valor
	 * @return boolean 				Resultado de la SQL
	 */
	public function updateCuestionarios($id, $nombre, $descripcion){
		$Sql = "UPDATE cuestionarios SET
				nombre='".$nombre."',
				descripcion='".$descripcion."' 
				WHERE id_cuestionario=".$id;
		return connection::execute_query($Sql);
	}

	public function deletePregunta($id){
		$Sql = "DELETE FROM cuestionarios_preguntas WHERE id_pregunta=".$id;
		if (connection::execute_query($Sql)){ 
			$Sql="DELETE FROM na_tareas_respuestas WHERE id_pregunta=".$id;
			connection::execute_query($Sql);
			return true;
		}
		else return false;
	}

	public function insertPregunta($id_cuestionario, $pregunta_texto, $pregunta_tipo){
		$Sql = "INSERT INTO cuestionarios_preguntas (id_cuestionario,pregunta_texto,pregunta_tipo) VALUES
		(".$id_cuestionario.",'".$pregunta_texto."','".$pregunta_tipo."')";
		return connection::execute_query($Sql);
	}

	public function insertPreguntaRespuesta($id_pregunta, $respuesta_texto, $correcta){
		$Sql = "INSERT INTO cuestionarios_respuestas (id_pregunta,respuesta_texto,correcta) VALUES
		(".$id_pregunta.",'".$respuesta_texto."',".$correcta.")";
		return connection::execute_query($Sql);
	}

	public function getPreguntas($filter = ""){
		$Sql = "SELECT * FROM cuestionarios_preguntas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getRespuestas($filter = ""){
		$Sql = "SELECT * FROM cuestionarios_respuestas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function insertRespuesta($id_pregunta, $respuesta_user, $respuesta_valor){
		//verificar si ya existe una respuesta para hacer insert o update
		if (connection::countReg("cuestionarios_respuestas_user", " AND id_pregunta=".$id_pregunta." AND respuesta_user='".$respuesta_user."' ") == 0)
			$Sql = "INSERT INTO cuestionarios_respuestas_user (id_pregunta,respuesta_user,respuesta_valor) VALUES
			(".$id_pregunta.",'".$respuesta_user."','".$respuesta_valor."')";
		else
			$Sql = "UPDATE cuestionarios_respuestas_user SET 
			respuesta_valor='".$respuesta_valor."' 
			WHERE id_pregunta=".$id_pregunta." AND respuesta_user='".$respuesta_user."' ";
		
		return connection::execute_query($Sql);
	}

	public function getFormulariosFinalizados($filter = ""){
		$Sql = "SELECT f.*,u.name AS name,u.nick AS nick FROM cuestionarios_finalizados f 
				LEFT JOIN users u ON u.username=f.user_tarea 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function insertFormulariosFinalizados($id_cuestionario, $user_tarea){
		$Sql = "INSERT INTO cuestionarios_finalizados (id_cuestionario,user_tarea) VALUES
		(".$id_cuestionario.",'".$user_tarea."')";
		return connection::execute_query($Sql);
	}

	public function getRespuestasUser($filter = ""){
		$Sql = "SELECT * FROM cuestionarios_respuestas_user 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getRespuestasUserAdmin($filter = ""){
		$Sql = "SELECT p.pregunta_texto AS Pregunta,r.respuesta_valor AS Respuesta FROM cuestionarios_preguntas p 
				LEFT JOIN cuestionarios_respuestas_user r ON r.id_pregunta=p.id_pregunta 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function RevisarTareaFormUser($usuario, $id_cuestionario, $puntos, $revisor){
		$Sql = "UPDATE cuestionarios_finalizados SET
				revision=1,
				puntos=".$puntos.",
				user_revision='".$revisor."',
				date_revision=NOW() 
				WHERE id_cuestionario=".$id_cuestionario." 
				AND user_tarea='".$usuario."' ";
		return connection::execute_query($Sql);
	}

	public function deleteFinalizacionForm($id_cuestionario, $filtro){
		$Sql = "DELETE FROM cuestionarios_finalizados 
				WHERE id_cuestionario=".$id_cuestionario." ".$filtro;
		return connection::execute_query($Sql);
	}

	public function deleteRespuestasForm($id_cuestionario, $filtro){
		$Sql = "DELETE FROM cuestionarios_respuestas WHERE id_pregunta IN
		(SELECT id_pregunta FROM cuestionarios_preguntas WHERE id_cuestionario=".$id_cuestionario.") ".$filtro;
		return connection::execute_query($Sql);
	}

	public function getFormulariosFinalizadosRespuestas($id_cuestionario, $usuario){
		$Sql = "SELECT ur.respuesta_valor FROM cuestionarios_respuestas_user ur
				LEFT JOIN cuestionarios_preguntas up ON up.id_pregunta=ur.id_pregunta
				WHERE id_cuestionario=".$id_cuestionario." AND ur.respuesta_user='".$usuario."' ORDER BY ur.id_pregunta ";
		return connection::getSQL($Sql);
	}
}
?>