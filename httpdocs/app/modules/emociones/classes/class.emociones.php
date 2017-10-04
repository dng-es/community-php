<?php
class emociones{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getEmociones($filter = ""){
		$Sql = "SELECT * 
				FROM emociones WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Elimina registro en emociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteEmociones($id){
		$Sql = "DELETE FROM emociones 
				WHERE id_emocion=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Deshabilita registro en emociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$estado 	valor campo active
	 * @return boolean 				Resultado de la SQL
	 */
	public function disableEmociones($id, $estado=0){
		$Sql = "UPDATE emociones SET 
				active=".$estado." 
				WHERE id_emocion=".$id;
		return connection::execute_query($Sql);
	}

	public function insertEmocion($fichero,$titulo){
		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = strtolower($nombre_archivo);
		$nombre_archivo = NormalizeText($nombre_archivo);
	
		if (move_uploaded_file($fichero['tmp_name'], "images/emociones/".$nombre_archivo)){
			//INSERTAR REGISTRO EN LA BBDD  
			$Sql = "INSERT INTO emociones (name_emocion,image_emocion) 
				 VALUES
				 ('".$titulo."','".$nombre_archivo."')";
			if (connection::execute_query($Sql)) return 0;
			else return 1;
		}
		else return 2;
	}

	public function updateEmocion($id,$document_file,$title){
		if ($document_file['name'] != ''){
			$nombre_archivo = time().'_'.str_replace(" ","_",$document_file['name']);
			$nombre_archivo = strtolower($nombre_archivo);
			$nombre_archivo = NormalizeText($nombre_archivo);
			if (move_uploaded_file($document_file['tmp_name'], "images/emociones/".$nombre_archivo)){
				$SqlUpdate = "image_emocion='".$nombre_archivo."', ";
			}
			else{
				ErrorMsg('Error al subir el documento.');
				return false;
			}
		}
		else $SqlUpdate = "";

		$Sql = "UPDATE emociones SET 
				".$SqlUpdate." 
				name_emocion='".$title."' 
				WHERE id_emocion=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getEmocionesUser($filter = ""){
		$Sql = "SELECT eu.*, e.*, u.* 
				FROM emociones_user eu
				LEFT JOIN emociones e ON e.id_emocion=eu.id_emocion 
				LEFT JOIN users u ON u.username=eu.user_emocion 
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public function insertEmocionUser($id_emocion, $user_emocion, $descripcion){
		//INSERTAR REGISTRO EN LA BBDD  
		$Sql = "INSERT INTO emociones_user (id_emocion,user_emocion,desc_emocion_user) 
			VALUES 
			(".$id_emocion.",'".$user_emocion."','".$descripcion."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getEmocionesConsejos($filter = ""){
		$Sql = "SELECT * 
				FROM emociones_consejos 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}	

	/**
	 * Deshabilita registro en emociones
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$estado 	valor campo active
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteConsejoEmociones($id){
		$Sql = "DELETE FROM emociones_consejos 
				WHERE id_consejo=".$id;
		return connection::execute_query($Sql);
	}	

	public function insertConsejoEmocionUser($id_emocion, $emocion_consejo){
		//INSERTAR REGISTRO EN LA BBDD  
		$Sql = "INSERT INTO emociones_consejos (id_emocion, emocion_consejo) 
			VALUES 
			(".$id_emocion.",'".$emocion_consejo."')";
		return connection::execute_query($Sql);
	}	
}
?>