<?php
class alertsController{
	public static function getListAction($reg = 0, $filter = "", $search = true){
		$find_reg = getFindReg();
		if ($find_reg != '' && $search == true) $filter .= " AND text_alert LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY date_ini DESC, time_ini DESC";

		$paginator_items = PaginatorPagesAlerts($reg);
		$total_reg = connection::countReg("alerts", $filter);
		return array('items' => alerts::getAlerts($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id, $filter = ""){
		$element = array();
		$elements = alerts::getAlerts(" AND id_alert=".$id." ".$filter);

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['id_alert_type'] = 0;
			$element['title_alert'] = '';
			$element['text_alert'] = '';
			$element['type_alert'] = '';
			$element['destination_alert'] = '';
			$element['date_alert'] = '';
			$element['user_post'] = '';
			$element['priority'] = '';
			$element['date_ini'] = date("Y-m-d");
			$element['date_fin'] = date("Y-m-d");
			$element['time_ini'] = '0:00:00';
			$element['time_fin'] = '23:59:59';
			$element['nombre_archivo'] = '';
			$element['registro'] = 0;
			$element['registro_limite'] = 0;
			$element['activa'] = 1;
		}
		return $element;
	}

	public static function createUserAction(){
		if (isset($_POST['id_alert']) && intval($_POST['id_alert']) == 0){
			if (self::createAction()) $id_alert = connection::SelectMaxReg("id_alert","alerts"," AND user_post='".$_SESSION['user_name']."' ");
			else $id_alert = 0;
			redirectURL($_SERVER['REQUEST_URI']."?ida=".$id_alert);
		}
	}

	public static function createAdminAction(){
		if (isset($_POST['id_alert']) && intval($_POST['id_alert']) == 0){
			if (self::createAction()) $id_alert = connection::SelectMaxReg("id_alert","alerts"," AND user_post='".$_SESSION['user_name']."' ");
			else $id_alert = 0;
			redirectURL("admin-alert?ida=".$id_alert);
		}
	}

	public static function createAction(){
		$alerts = new alerts();
		$title_alert = trim(sanitizeInput($_POST['title_alert']));
		$text_alert = trim(sanitizeInput($_POST['text_alert']));
		$type_alert = trim(sanitizeInput($_POST['type_alert']));
		$priority = trim(sanitizeInput($_POST['priority']));
		$date_ini = trim(sanitizeInput($_POST['date_ini']));
		$date_fin = trim(sanitizeInput($_POST['date_fin']));
		$time_ini = trim(sanitizeInput($_POST['time_ini']));
		$time_fin = trim(sanitizeInput($_POST['time_fin']));
		$nombre_archivo = ($_FILES['nombre_archivo']['name'] != "" ? self::insertDocument($_FILES['nombre_archivo']) : "");
		$id_alert_type = intval($_POST['id_alert_type']);
		$destination_alert = sanitizeInput($_POST['destination_alert']);
		if (is_array($destination_alert)) $destination_alert = implode(",", $destination_alert);
		$destination_alert .= ",";
		$registro = (isset($_POST['registro']) && $_POST['registro'] == "on") ? 1 : 0;
		$registro_limite = isset($_POST['registro_limite']) ? trim(sanitizeInput($_POST['registro_limite'])) : 0;

		if ($alerts->insertAlerts(
			$title_alert,
			$text_alert,
			$type_alert,
			$destination_alert,
			$_SESSION['user_name'],
			$priority,
			$date_ini,
			$date_fin,
			$id_alert_type,
			$time_ini,
			$time_fin,
			$nombre_archivo,
			$registro,
			$registro_limite
			)){
			session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), 'alert alert-success');
			return true;
		}
		else{
			session::setFlashMessage('actions_message', strTranslate("Error_procesing"), 'alert alert-danger');
			return false;
		}

	}

	public static function updateAction(){
		if (isset($_POST['id_alert']) && intval($_POST['id_alert']) > 0){
			$alerts = new alerts();
			$id_alert = trim(sanitizeInput($_POST['id_alert']));
			$title_alert = trim(sanitizeInput($_POST['title_alert']));
			$text_alert = trim(sanitizeInput($_POST['text_alert']));
			$type_alert = trim(sanitizeInput($_POST['type_alert']));
			$priority = trim(sanitizeInput($_POST['priority']));
			$date_ini = trim(sanitizeInput($_POST['date_ini']));
			$date_fin = trim(sanitizeInput($_POST['date_fin']));
			$time_ini = trim(sanitizeInput($_POST['time_ini']));
			$time_fin = trim(sanitizeInput($_POST['time_fin']));
			$nombre_archivo = ($_FILES['nombre_archivo']['name'] != "" ? self::insertDocument($_FILES['nombre_archivo']) : "");
			$id_alert_type = intval($_POST['id_alert_type']);
			$destination_alert = sanitizeInput($_POST['destination_alert']);
			if (is_array($destination_alert)) $destination_alert = implode(",", $destination_alert);
			$destination_alert .= ",";
			$registro = (isset($_POST['registro']) && $_POST['registro'] == "on") ? 1 : 0;
			$registro_limite = isset($_POST['registro_limite']) ? trim(sanitizeInput($_POST['registro_limite'])) : 0;


			if ($alerts->updateAlerts(
				$id_alert,
				$title_alert,
				$text_alert,
				$type_alert,
				$destination_alert,
				$priority,
				$date_ini,
				$date_fin,
				$id_alert_type,
				$time_ini,
				$time_fin,
				$nombre_archivo,
				$registro,
				$registro_limite
				))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), 'alert alert-success');
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), 'alert alert-danger');

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function insertDocument($fichero){
		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = NormalizeText($nombre_archivo);
		$path_archivo ="docs/info/";
		if (move_uploaded_file($fichero['tmp_name'], $path_archivo.$nombre_archivo)) return $nombre_archivo;
		else return false;
    }

	public static function deleteAction($destination = "admin-alerts"){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'dela'){
			if (alerts::disableAlerts(intval($_REQUEST['id']), 0))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
			redirectURL($destination."?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function exportRegistroAction($filter = ""){
		if (isset($_REQUEST['export_r']) && $_REQUEST['export_r'] == true){
			$id_alert = (isset($_REQUEST['ida']) ? intval($_REQUEST['ida']) : 0);
			$filter = " AND i.id_alert=".$id_alert." ".self::getFiltroAlerts("", "").$filter;
			$elements = alerts::getAlertsRegistroExport($filter);
			download_send_headers(strTranslate("MOD_Alerts")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}	

	public static function getFiltroAlerts($search_user_filter = "", $search_tienda_filter = ""){
		$filter_user = usersController::getTiendaFilter("empresa");
		$filter_tienda = usersController::getTiendaFilter("cod_tienda");
		$filter = " AND (SPLIT_STRING(destination_alert, ',', 1) IN (SELECT username FROM users WHERE 1=1 ".$search_user_filter." ".$filter_user.") OR SPLIT_STRING(destination_alert, ',', 1) IN (SELECT cod_tienda FROM users_tiendas WHERE 1=1 ".$search_tienda_filter." ".$filter_tienda.")) ";
		return $filter;

	}	
}
?>