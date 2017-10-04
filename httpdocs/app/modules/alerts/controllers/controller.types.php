<?php
class alertsTypesController{
	public static function getListAction($reg = 0, $filter = "", $search = true){
		$find_reg = getFindReg();
		if ($find_reg != '' && $search == true) $filter .= " AND name_type LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY name_type ASC";

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("alerts_types", $filter);
		return array('items' => alerts::getAlertsTypes($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function deleteAction($destination = "admin-alerts-types"){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			if (alerts::disableAlertsTypes(intval($_REQUEST['id']), 0))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
			redirectURL($destination."?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) && intval($_POST['id']) > 0){
			$alerts = new alerts();
			$id = trim(sanitizeInput($_POST['id']));
			$name_type = trim(sanitizeInput($_POST['name_type']));
			$color_type = trim(sanitizeInput($_POST['color_type']));
			$icon_type = trim(sanitizeInput($_POST['icon_type']));
			$aprobacion = (isset($_POST['aprobacion']) && $_POST['aprobacion'] == "on") ? 1 : 0;			
			$perfiles_type = sanitizeInput($_POST['perfiles_type']);
			if (is_array($perfiles_type)) $perfiles_type = implode(",", $perfiles_type);
			$perfiles_type .= ",";

			if ($alerts->updateAlertsType($id, $name_type, $color_type, $icon_type, $perfiles_type, $aprobacion))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), 'alert alert-success');
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), 'alert alert-danger');

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}	

	public static function createAction(){
		if (isset($_POST['id']) && intval($_POST['id']) == 0){
			$alerts = new alerts();
			$name_type = trim(sanitizeInput($_POST['name_type']));
			$color_type = trim(sanitizeInput($_POST['color_type']));
			$icon_type = trim(sanitizeInput($_POST['icon_type']));
			$aprobacion = (isset($_POST['aprobacion']) && $_POST['aprobacion'] == "on") ? 1 : 0;			
			$perfiles_type = sanitizeInput($_POST['perfiles_type']);
			if (is_array($perfiles_type)) $perfiles_type = implode(",", $perfiles_type);
			$perfiles_type .= ",";

			if ($alerts->insertAlertsType($name_type, $color_type, $icon_type, $perfiles_type, $aprobacion)){
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), 'alert alert-success');
				$id = connection::SelectMaxReg("id_alert_type","alerts_types","");
			}
			else{
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), 'alert alert-danger');
				$id = 0;
			}
			redirectURL("admin-alerts-type?id=".$id);
		}
	}

	public static function getItemAction($id, $filter = ""){
		$element = array();
		$elements = alerts::getAlertsTypes(" AND id_alert_type=".$id." ".$filter);

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['id_alert_type'] = 0;
			$element['name_type'] = '';
			$element['color_type'] = '';
			$element['icon_type'] = '';
			$element['perfiles_type'] = '';
			$element['aprobacion'] = 0;
		}
		return $element;
	}	
}
?>