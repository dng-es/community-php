<?php
class campaignsController{
	public static function getListAction($reg = 0, $filter = ""){
		$campaigns = new campaigns();
		$filtro = $filter." AND active=1 ORDER BY name_campaign ASC ";

		$find_reg = (isset($_GET['f']) and $_GET['f'] > 0) ? $_GET['f'] : "";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("campaigns c",$filtro);
		return array('items' => $campaigns->getCampaigns($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		$id_campaign = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id_campaign != 0){
			$campaigns = new campaigns();
			$plantilla = $campaigns->getCampaigns(" AND active=1 AND id_campaign=".$id_campaign);
			return  $plantilla[0];
		}
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$campaigns = new campaigns();
			$elements = $campaigns->getCampaigns(" AND active=1 ORDER BY name_campaign DESC ");
			download_send_headers("campaigns_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction(){
		if (isset($_POST['name_campaign']) and $_POST['name_campaign'] != "" and $_POST['id_campaign'] == 0){
			$campaigns = new campaigns();
			$id_campaign = 0;
			$name_campaign = sanitizeInput($_POST['name_campaign']);
			$desc_campaign = sanitizeInput($_POST['desc_campaign']); 
			$id_type = intval($_POST['id_type']);
			$novedad = intval(($_POST['novedad'] == 'on') ? 1 : 0);
			$canal_campaign = sanitizeInput($_POST['canal_campaign']);
			if (is_array($canal_campaign)) $canal_campaign = implode(",", $canal_campaign);

			$imagen_mini = uploadFileToFolder($_FILES['nombre-fichero'], "images/banners/");
			$imagen_big = uploadFileToFolder($_FILES['nombre-fichero-big'], "images/banners/");

			if ($campaigns->insertCampaigns($name_campaign, $desc_campaign, $id_type, $imagen_mini, $imagen_big, $novedad, $canal_campaign)) {
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id_campaign = connection::SelectMaxReg("id_campaign","campaigns","");
			}
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaign?id=".$id_campaign);
		}
	}

	public static function updateAction(){
		if (isset($_POST['name_campaign']) and $_POST['name_campaign'] != "" and $_POST['id_campaign'] > 0){
			$campaigns = new campaigns();
			$id_campaign = intval($_POST['id_campaign']);
			$name_campaign = sanitizeInput($_POST['name_campaign']);
			$desc_campaign = sanitizeInput($_POST['desc_campaign']);
			$id_type = $_POST['id_type'];
			$novedad = intval(($_POST['novedad'] == 'on') ? 1 : 0);
			$canal_campaign = sanitizeInput($_POST['canal_campaign']);
			if (is_array($canal_campaign)) $canal_campaign = implode(",", $canal_campaign);

			$imagen_mini = uploadFileToFolder($_FILES['nombre-fichero'], "images/banners/");
			$imagen_big = uploadFileToFolder($_FILES['nombre-fichero-big'], "images/banners/");		

			if ($campaigns->updateCampaigns($id_campaign, $name_campaign, $desc_campaign, $id_type, $imagen_mini, $imagen_big, $novedad, $canal_campaign)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaign?id=".$id_campaign);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$campaigns = new campaigns();
			if ($campaigns->deleteCampaigns($_REQUEST['id'])) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaigns");
		}
	}

	public static function getListTypesAction($reg = 0){
		$campaigns = new campaigns();
		$filtro = " ORDER BY campaign_type_name ASC ";
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("campaigns_types",$filtro);
		return array('items' => $campaigns->getCampaignsTypes($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemTypesAction($id = 0){
		$id = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : (isset($_REQUEST['f']) ? $_REQUEST['f'] : 0));
		if ($id != 0){
			$campaigns = new campaigns();
			$plantilla = $campaigns->getCampaignsTypes(" AND id_campaign_type=".$id);
			return $plantilla[0];
		}
	}

	public static function createTypeAction(){
		if (isset($_POST['name']) and $_POST['name']!="" and $_POST['id'] == 0){
			$campaigns = new campaigns();
			$id = 0;
			$name = sanitizeInput($_POST['name']);
			$desc = sanitizeInput($_POST['desc']);

			if ($campaigns->insertCampaignsType($name, $desc)) {
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id = connection::SelectMaxReg("id_campaign_type", "campaigns_types", "");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaigns-type?id=".$id);
		}
	}

	public static function updateTypeAction(){
		if (isset($_POST['name']) and $_POST['name'] != "" and $_POST['id'] > 0){
			$campaigns = new campaigns();
			$id = intval($_POST['id']);
			$name = sanitizeInput($_POST['name']);
			$desc = sanitizeInput($_POST['desc']);

			if ($campaigns->updateCampaignsType($id, $name, $desc)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaigns-type?id=".$id);
		}
	}

	public static function deleteTypeAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$campaigns = new campaigns();
			if ($campaigns->deleteCampaignsType(intval($_REQUEST['id']))) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-campaigns-types");
		}
	}
}
?>