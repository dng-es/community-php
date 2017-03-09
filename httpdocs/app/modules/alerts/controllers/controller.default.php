<?php
class alertsController{
	public static function getListAction($reg = 0, $filtro = ""){
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND text_alert LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND text_alert LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY date_ini DESC";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("alerts",$filtro);
		return array('items' => alerts::getAlerts($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['text_alert']) && trim($_POST['text_alert'])){
			$alerts = new alerts();

			if ($alerts->insertAlerts(sanitizeInput($_POST['text_alert']), sanitizeInput($_POST['type_alert']), sanitizeInput($_POST['destination_alert']), $_SESSION['user_name'], sanitizeInput($_POST['priority']), sanitizeInput($_POST['date_ini']." 00:00:00"), sanitizeInput($_POST['date_fin']." 23:59:59")))
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), 'alert alert-success');
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), 'alert alert-danger');

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			if (alerts::disableAlerts(intval($_REQUEST['id']), 0)) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("admin-alerts?pag=".$pag."&f=".$find_reg);
		}
	}
}
?>