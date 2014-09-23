<?php
/**
* @Mensajeria interna
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/
class mensajes{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getMensajes($filter = ""){
		$Sql="SELECT m.*,u.* FROM mensajes m
			JOIN users u ON u.username=m.user_remitente WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getMensajesEnviados($filter = ""){
		$Sql="SELECT m.*,u.* FROM mensajes m
			 JOIN users u ON u.username=m.user_destinatario WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Inserta registro en mensajes
	 * @return int 				devulve: 0->ok; 1->error; 2->usuario no encontrado; 3->mensaje a si mismo
	 */
	public function InsertMensaje($remitente_nick,$remitente_nombre,$remitente_email,$nick_destinatario,$asunto,$mensaje,$grupo_invitacion = 0){
		//VERIFICAR QUE EL USUARIO NO SE ENVIE A SI MISMO
		if ($remitente_nick!=$nick_destinatario){
			//VERIFICAR QUE EL USUARIO DESTINATARIO EXISTE
			$users = new users;
			$usuario = $users->getUsers(" AND nick='".$nick_destinatario."' ");
			$destinatario = $usuario[0]['username'];
					
			if (count($usuario)==1){
				//INSERTAR REGISTRO EN BBDD
				$Sql="INSERT INTO mensajes (user_remitente,user_destinatario,asunto_mensaje,mensaje_cuerpo) VALUES (
					 '".$remitente_nombre."','".$destinatario."','".$asunto."','".$mensaje."')";
				if (connection::execute_query($Sql)){
						return 0;
				}
				else { return 1;}
			}
			else {return 2;}
		}
		else {return 3;}
      }

	/**
	 * Elimina registro en mensajes
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteMensajeRecibido($id){
		$Sql="UPDATE mensajes SET estado=2 WHERE id_mensaje=".$id;
		return connection::execute_query($Sql);
	}

    public function deleteMensajeEnviado($id){
	  	$Sql="UPDATE mensajes SET estado_remitente=1 WHERE id_mensaje=".$id;
		return connection::execute_query($Sql);
    }
	  
	public function leerMensaje($id){
		//PRIMERO COMPROBAMOS QUE SEA EL DUEÑO DEL MENSAJE
	  	$mensaje_data=$this->getMensajes(" AND id_mensaje=".$id." ");
	  	if ($mensaje_data[0]['user_destinatario']==$_SESSION['user_name']){
			$Sql="UPDATE mensajes SET estado=1 WHERE id_mensaje=".$id;
			return connection::execute_query($Sql);
		}
    }
}
?>