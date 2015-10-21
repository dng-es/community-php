<?php
class muro{ 
	public function getComentarios($filter = ""){
		$Sql = "SELECT c.*,u.*,c.canal AS canal_comentario FROM muro_comentarios c 
				JOIN users u ON u.username=c.user_comentario 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function InsertComentario($canal, $texto_comentario, $usuario, $estado, $tipo, $tipo_comentario = ''){
		$Sql = "INSERT INTO muro_comentarios (canal,comentario,user_comentario,estado,tipo_muro,seccion_comentario) VALUES 
				('".$canal."','".$texto_comentario."','".$usuario."',".$estado.",'".$tipo."','".$tipo_comentario."')";	 
		if (connection::execute_query($Sql)){ 
			if ($estado==1){users::sumarPuntos($usuario, PUNTOS_MURO, PUNTOS_MURO_MOTIVO);}
			return "Comentario insertado correctamente.";
		}
		else return "Se ha producido un error en la inserción de su comentario. Por favor, inténtelo más tarde.";
	}

	public function InsertRespuesta($canal, $texto_comentario, $usuario, $estado, $tipo, $id_responder){
		$Sql = "INSERT INTO muro_comentarios (canal,comentario,user_comentario,estado,tipo_muro,id_comentario_id) VALUES 
				('".$canal."','".$texto_comentario."','".$usuario."',".$estado.",'".$tipo."',".$id_responder.")";
		if (connection::execute_query($Sql)){ 
			//SUMAR PUNTOS
			$users = new users();
			$users->sumarPuntos($usuario, PUNTOS_MURO, PUNTOS_MURO_MOTIVO);
			return "Comentario insertado correctamente.";
		}
		else return "Se ha producido un error en la inserción de su comentario. Por favor, inténtelo más tarde.";
	}

	public function responderComentario($canal, $texto_comentario, $usuario, $estado, $tipo, $id_comentario_responder){
		$Sql = "INSERT INTO muro_comentarios (canal,comentario,user_comentario,estado,tipo_muro,id_comentario_id) VALUES 
			 ('".$canal."','".$texto_comentario."','".$usuario."',".$estado.",'".$tipo."',".$id_comentario_responder.")";
		
		if (connection::execute_query($Sql)) return "Comentario insertado correctamente.";
		else return "Se ha producido un error en la inserción de su comentario. Por favor, inténtelo más tarde.";
	}

	public function responderComentarioMuro($usuario, $estado, $id_comentario_responder, $texto_comentario){
		$comentario_original = self::getComentarios(" AND id_comentario=".$id_comentario_responder." ");
		$Sql = "INSERT INTO muro_comentarios (canal,comentario,user_comentario,estado,tipo_muro,id_comentario_id) VALUES 
			 ('".$comentario_original[0]['canal_comentario']."','".$texto_comentario."','".$usuario."',".$estado.",'".$comentario_original[0]['tipo_muro']."',".$id_comentario_responder.")";
		echo $Sql;
		if (connection::execute_query($Sql)) return "Comentario insertado correctamente.";
		else return "Se ha producido un error en la inserción de su comentario. Por favor, inténtelo más tarde.";
	}

	public function InsertVotacion($id, $usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("muro_comentarios"," AND id_comentario=".$id." AND user_comentario='".$usuario."' ") == 0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO COMENTARIO
			if (connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$id." AND user_votacion='".$usuario."' ") == 0){
				//INSERTAR COMENTARIO
				$Sql = "INSERT INTO muro_comentarios_votaciones (id_comentario,user_votacion) VALUES (
					 ".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql = "UPDATE muro_comentarios
					  SET votaciones=votaciones+1 
					  WHERE id_comentario=".$id;
				connection::execute_query($Sql);			
				return "Votación realizada con éxito.";
			}
			else return "Ya ha votado este comentario.";
		}
		else return "No puede votar sus propios comentarios.";
	}

	public function cambiarEstado($id, $estado, $seleccionado = 0){
		$Sql = "UPDATE muro_comentarios SET
			 estado=".$estado.",
			 seleccion_reto=".$seleccionado."
			 WHERE id_comentario=".$id."";
		return connection::execute_query($Sql);
	}
}
?>