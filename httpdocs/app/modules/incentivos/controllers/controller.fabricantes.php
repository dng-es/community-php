<?php
class incentivosFabricantesController{
	public static function getListAction($reg = 0, $filter = ""){
		$incentivos = new incentivos();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND nombre_fabricante LIKE '%".$find_reg."%' ";
		$filter .= " AND activo_fabricante=1 ORDER BY nombre_fabricante";
		
		$paginator_items = PaginatorPages($reg);		
		$total_reg = connection::countReg("incentives_fabricantes", $filter); 
		return array('items' => $incentivos->getIncentivesFabricantes($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['fabricante-nombre']) and trim($_POST['fabricante-nombre']) != ""){
			$nombre_fabricante = sanitizeInput($_POST['fabricante-nombre']);
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesFabricantes($nombre_fabricante))
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-fabricantes");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_fabricante = intval( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesFabricantes($id_fabricante))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-fabricantes");
		}
	}

	public static function exportAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true){
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesFabricantes("");
			download_send_headers(strTranslate("Incentives_manufacturers")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>