<?php
class info{
 
	public function getInfo($filter = ""){
		$Sql = "SELECT i.*,t.nombre_info AS tipo,c.name_campaign AS campana FROM info i 
				LEFT JOIN info_tipo t ON i.tipo_info=t.id_tipo 
				LEFT JOIN campaigns c ON i.id_campaign=c.id_campaign 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getInfoTipos($filter = ""){
		$Sql = "SELECT * FROM info_tipo
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function deleteInfo($id, $documento){
		unlink(PATH_INFO.$documento);
		$Sql = "DELETE FROM info
				WHERE id_info=".$id;
		return connection::execute_query($Sql);
	}

	public function insertInfo($nombre_archivo, $titulo, $canal, $tipo, $id_campaign, $download){
		$Sql = "INSERT INTO info (titulo_info,file_info,canal_info,tipo_info,id_campaign,download) 
				VALUES
				('".$titulo."','".$nombre_archivo."','".$canal."',".$tipo.",".$id_campaign.",".$download.")";
		return connection::execute_query($Sql);
	}

	public function updateInfo($id, $title, $canal, $tipo, $id_campaign, $download){
		$Sql = "UPDATE info SET
				titulo_info='".$title."',
				canal_info='".$canal."', 
				tipo_info=".$tipo.",
				download=".$download.",
				id_campaign=".$id_campaign." 
				WHERE id_info=".$id;
		return connection::execute_query($Sql);
	}

	public function updateInfoDoc($id, $nombre_archivo){
		$Sql = "UPDATE info SET
				file_info='".$nombre_archivo."' 
				WHERE id_info=".$id;
		return connection::execute_query($Sql);
	}

	public function insertAlerts(){
		$Sql = "INSERT INTO info_alerts (id_info,username_alert)
				SELECT id_info, '".$_SESSION['user_name']."' FROM info WHERE id_info NOT IN (SELECT  id_info FROM info_alerts WHERE username_alert = '".$_SESSION['user_name']."')";
		return connection::execute_query($Sql);
	}

	public function insertInfoView($user_file, $id_file){
		$Sql = "INSERT INTO info_views (username_view,id_file) 
				VALUES ('".$user_file."',".$id_file.")";
		return connection::execute_query($Sql);
	}

	public function getInfoViews($filter = ""){
		$Sql = "SELECT * FROM info_views
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}
}
?>
