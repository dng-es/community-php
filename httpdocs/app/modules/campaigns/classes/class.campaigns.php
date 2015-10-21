<?php
class campaigns{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getCampaigns($filter = ""){
		$Sql = "SELECT c.*,t.campaign_type_name AS tipo 
				FROM campaigns c LEFT JOIN campaigns_types t ON t.id_campaign_type=c.id_campaign_type 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Inserta registro en campaigns
	 * @param  string	$name_campaign 		Nombre de la campaña
	 * @param  string	$desc_campaign 		Descripción de la campaña
	 * @param  string	$id_type 			Id tipo de campaña (tabla campaigns_types)
	 * @param  string	$imagen_mini 		Nombre del archivo de la imagen mini
	 * @param  string	$imagen_big 		Nombre del archivo de la imagen big
	 * @return boolean 						Resultado de la SQL
	 */
	public function insertCampaigns( $name_campaign, $desc_campaign, $id_type, $imagen_mini, $imagen_big, $novedad){		
		$Sql = "INSERT INTO campaigns (name_campaign,desc_campaign, id_campaign_type, imagen_mini, imagen_big, novedad) 
				VALUES ('".$name_campaign."','".$desc_campaign."',".$id_type.",'".$imagen_mini."','".$imagen_big."',".$novedad.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en campaigns
	 * @param  int 		$id 				Id registro a eliminar
	 * @return boolean 						Resultado de la SQL
	 */
	public function deleteCampaigns($id){
		$Sql = "UPDATE campaigns SET active=0 WHERE id_campaign=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en campaigns
	 * @param  int 		$id 				Id registro a actualizar
	 * @param  string	$name_campaign 		Nombre de la campaña
	 * @param  string	$desc_campaign 		Descripción de la campaña
	 * @param  string	$id_type 			Id tipo de campaña (tabla campaigns_types)
	 * @param  string	$imagen_mini 		Nombre del archivo de la imagen mini
	 * @param  string	$imagen_big 		Nombre del archivo de la imagen big
	 * @param  int 		$novedad 			Indica si es novedad-> 1:si ; 2:no
	 * @return boolean 						Resultado de la SQL
	 */
	public function updateCampaigns($id, $name_campaign, $desc_campaign, $id_type, $imagen_mini, $imagen_big, $novedad){
		$Sql_file_mini = ($imagen_mini == "") ? "" : ", imagen_mini='".$imagen_mini."' ";
		$Sql_file_big = ($imagen_big == "") ? "" : ", imagen_big='".$imagen_big."' ";
		$Sql = "UPDATE campaigns SET
				id_campaign_type=".$id_type.",
				novedad=".$novedad.",
				name_campaign='".$name_campaign."',
				desc_campaign='".$desc_campaign."' 
				".$Sql_file_mini."
				".$Sql_file_big."
				WHERE id_campaign=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los tipos de campañas
	 * @param  string 	$filter 			Filtro SQL
	 * @return array 						Array con registros
	 */
	public function getCampaignsTypes($filter = ""){
		$Sql = "SELECT * FROM campaigns_types WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Elimina registro en campaigns_types
	 * @param  int 		$id 				Id registro a eliminar
	 * @return boolean 						Resultado de la SQL
	 */
	public function deleteCampaignsType($id){
		$Sql = "DELETE FROM campaigns_types WHERE id_campaign_type=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza registro en campaigns
	 * @param  int 		$id 				Id registro a actualizar
	 * @param  string	$name 				Nombre del tipo de campaña
	 * @param  string	$desc 				Descripción del tipo de campaña
	 * @return boolean 						Resultado de la SQL
	 */
	public function updateCampaignsType($id, $name, $desc){
		$Sql = "UPDATE campaigns_types SET
				campaign_type_name='".$name."',
				campaign_type_desc='".$desc."' 
				WHERE id_campaign_type=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Insertar registro en campaigns
	 * @param  string	$name 				Nombre del tipo de campaña
	 * @param  string	$desc 				Descripción del tipo de campaña
	 * @return boolean 						Resultado de la SQL
	 */
	public function insertCampaignsType($name, $desc){
		$Sql = "INSERT INTO campaigns_types (campaign_type_name, campaign_type_desc) VALUES ('".$name."','".$desc."')";
		return connection::execute_query($Sql);
	}
}
?>