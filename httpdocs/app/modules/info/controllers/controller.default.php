<?php

class infoController{
	public static function getListAction($reg = 0, $filter = ""){
		$info = new info();
		$filtro = $filter." ORDER BY titulo_info";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("info i",$filtro);
		return array('items' => $info->getInfo($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$info = new info();
		return $info->getInfo(" AND id_info=".$id);
	}

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$info = new info();
			$download = ($_POST['download'] == "on" ? 1 : 0);
			$canal = sanitizeInput($_POST['info_canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			if ($download == 1){
				$nombre_archivo = uploadFileToFolder($_FILES['info_file'], PATH_INFO);
				if ($nombre_archivo == '') session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
				else $info->updateInfoDoc(intval($_POST['id']), $nombre_archivo);
			}
			else $nombre_archivo = sanitizeInput($_POST['info_url']);

			if ($info->insertInfo($nombre_archivo, sanitizeInput($_POST['info_title']), $canal, sanitizeInput($_POST['info_tipo']), sanitizeInput($_POST['info_campana']), $download)){
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id = connection::SelectMaxReg("id_info", "info", "");
				redirectURL("admin-info-doc?act=edit&id=".$id);
			}
			else{
				session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo generarse el registro.", "alert alert-danger");
				redirectURL("admin-info-doc?act=new");
			}
		}
	}

	public static function updateAction($id){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$info = new info();
			$download = ($_POST['download'] == "on" ? 1 : 0);
			$canal = sanitizeInput($_POST['info_canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			if ($download == 1){
				if ($_FILES['info_file']['name'] != '') {
					$nombre_archivo = uploadFileToFolder($_FILES['info_file'], PATH_INFO);
					if ($nombre_archivo == '') session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
					else $info->updateInfoDoc($_POST['id'], $nombre_archivo);
				}

			}
			else $info->updateInfoDoc(intval($_POST['id']), sanitizeInput($_POST['info_url']));

			if ($info->updateInfo(intval($_POST['id']), sanitizeInput($_POST['info_title']), $canal, sanitizeInput($_POST['info_tipo']), sanitizeInput($_POST['info_campana']), $download)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-info-doc?act=edit&id=".$id);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$info = new info();
			if ($info->deleteInfo(intval($_REQUEST['id']), sanitizeInput($_REQUEST['d']))) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-info");
		}
	}

	public static function getZipAction(){
		if (isset($_REQUEST['exp']) and $_REQUEST['exp'] != ""){
			fileToZip($_REQUEST['exp'], PATH_INFO);
		}
	}

	public static function insertAlerts(){
		$info = new info();
		$info -> insertAlerts();
	}

	public static function getAlerts(){
		$info = new info();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_info LIKE '%".$_SESSION['user_canal']."%' " : "");
		$noLeidos = connection::countReg("info", $filtro_canal." AND id_info NOT IN (SELECT id_info FROM info_alerts WHERE username_alert = '".$_SESSION['user_name']."')");
		return $noLeidos;
	}

	public static function registerViewAction($user_file, $id_info){
		$info = new info();
		$contador = connection::countReg("info_views"," AND username_view='".$user_file."' AND id_file=".$id_info."");
		if ($info->insertInfoView($user_file, $id_info)){
			if ($contador == 0){
				$users = new users();
				$users->sumarPuntos($user_file, PUNTOS_INFO, PUNTOS_INFO_MOTIVO." ID: ".$id_info);
			}
		}
	}

	public static function exportViewsAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$info = new info();
			$elements = $info->getInfoViews("");
			download_send_headers("users_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>