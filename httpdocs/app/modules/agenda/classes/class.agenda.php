<?php
class agenda{
	public function insertAlerts(){
		$Sql = "INSERT INTO blog_alerts (id_tema,username_alert)
				SELECT id_tema, '".$_SESSION['user_name']."' FROM foro_temas WHERE ocio=1 AND id_tema NOT IN (SELECT id_tema FROM blog_alerts WHERE username_alert = '".$_SESSION['user_name']."')";
		return connection::execute_query($Sql);
	}

	public function getAgenda($filter = ""){
		$Sql = "SELECT * FROM agenda a
		LEFT JOIN agenda_tipos t ON a.tipo = t.id_agenda_tipo WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getTipos($filter = ""){
		$Sql = "SELECT * FROM agenda_tipos WHERE 1=1 ".$filter;

		//echo $Sql;
		return connection::getSQL($Sql);
	}

	public function insertActividad($titulo, $descripcion,$banner,$dateIni,$dateFin, $fichero,$tipo,$canal,$activo,$etiquetas){

		//Carga del banner
		if (isset($banner['name']) and $banner['name'] != "") $banner = self::insertActividadFoto($banner);
		else $banner = '';

		//Formato fecha
		if (is_null($dateIni)||($dateIni=='')) {
			$date_ini='NULL';
		}
		else{
			$date1 = str_replace('/', '-', trim(sanitizeInput($dateIni)));
			$date_ini = date('Y-m-d',strtotime($date1));
		}
		if (is_null($dateFin)||($dateFin=='')) {
			$date_fin='NULL';
		}
		else{
			$date2 = str_replace('/', '-', trim(sanitizeInput($dateFin)));
			$date_fin = date('Y-m-d',strtotime($date2));
		}

		$Sql = "INSERT INTO agenda (titulo,descripcion,banner,date_ini,date_fin,archivo,tipo,canal, user_add,activo,etiquetas)
				VALUES ('".$titulo."','".$descripcion."','".$banner."','".$date_ini."','".$date_fin."','".$fichero."',".$tipo.",'".$canal."','".$_SESSION['user_name']."',".$activo.",'".$etiquetas."')";
			//echo $Sql;die;

		return connection::execute_query($Sql);
	}

	public function insertActividadFoto($fichero){

		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = NormalizeText($nombre_archivo);

		$tipo_archivo = $fichero['type'];
		$tamano_archivo = $fichero['size'];
		//compruebo si las características del archivo son las que deseo
		if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < MAX_SIZE_FOTOS))) {
			return false;
		}else{
			if (move_uploaded_file($fichero['tmp_name'], "images/banners/".$nombre_archivo)) return $nombre_archivo;
			else return false;
		}
	}

	public function updateActividad($id,$nombre, $descripcion,$banner,$dateIni,$dateFin, $fichero,$tipo,$canal,$activo,$etiquetas){
		//echo "id ".$id;

		//Carga del banner
		if (isset($banner['name']) and $banner['name'] != "") $banner = self::insertActividadFoto($banner);
		else $banner = '';

		//Formato fecha
		$Sql = "UPDATE agenda SET titulo = '".$nombre."',descripcion='".$descripcion."'";
		if ($banner<>''){$Sql .= ",banner='".$banner."'";}
		if (is_null($dateIni)||($dateIni=='')) {$date_ini='NULL';$Sql .= ",date_ini=".$date_ini;}
		else{
			$date1 = str_replace('/', '-', trim(sanitizeInput($dateIni)));
			$date_ini = date('Y-m-d',strtotime($date1));
			$Sql .= ",date_ini='".$date_ini."'";
		}
		if (is_null($dateFin)||($dateFin=='')) {$date_fin='NULL';$Sql .= ",date_fin=".$date_fin;}
		else{
			$date2 = str_replace('/', '-', trim(sanitizeInput($dateFin)));
			$date_fin = date('Y-m-d',strtotime($date2));
			$Sql .= ",date_fin='".$date_fin."'";
		}

		if ((isset($fichero))&& ($fichero!='')){$Sql .= ",archivo='".$fichero."'";}
		$Sql .= ",tipo=".$tipo.",canal='".$canal."' ,activo=".$activo.",etiquetas='".$etiquetas."' WHERE 1=1 AND id_agenda=".$id;

	//	echo $Sql;

		return connection::execute_query($Sql);
	}

	public function cambiarEstadoAgenda($id, $activo){
		$Sql = "UPDATE agenda SET
				activo=".$activo."
				WHERE id_agenda=".$id."";
		return connection::execute_query($Sql);
	}

	public function deleteAgenda($id){
		$Sql = "DELETE FROM agenda 
				WHERE id_agenda=".$id."";
		return connection::execute_query($Sql);
	}	

	public function getCategorias($filter = ""){
		$Sql = "SELECT DISTINCT etiquetas AS categoria FROM agenda WHERE etiquetas<>'' ".$filter;
		$result = connection::execute_query($Sql);
		$registros = "";
		while ($registro = connection::get_result($result)){
			$registros .= ",".str_replace(", ", ",", $registro['categoria']);
		}
		$registros = substr($registros, 1, strlen($registros));
		$registros =  explode(",", $registros);
		$registros = array_values(array_unique($registros));
		return $registros;
	}

	public function getTags($filter = ""){
		$Sql = "SELECT GROUP_CONCAT(etiquetas) AS tag FROM agenda WHERE activo=1 ".$filter;
		$result = connection::getSQL($Sql);
		$registros = str_replace(', ',',',$result[0]['tag']);
		$registros =  explode(",", $registros);
		$registros = array_count_values($registros);
		return $registros;
	}
}
?>