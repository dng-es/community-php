<?php
class shopManufacturersController{
	public static function getItemAction($id){
		$shop = new shop();
		$element = array();
		$elements = $shop->getManufacturers(" AND id_manufacturer=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['name_manufacturer'] = "";
			$element['active_manufacturer'] = "";
		}

		return $element;
	}

	public static function getListAction($reg = 0, $filter = ""){
		$shop = new shop();
		$find_reg = "";

		if (isset($_REQUEST['name_search'])) $find_reg .= "&name_search=".$_REQUEST['name_search'];

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("shop_manufacturers",$filter); 
		return array('items' => $shop->getManufacturers($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction($filter = ""){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$shop = new shop(); 
			$elements = $shop->getManufacturers($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction(){
		if (isset($_POST['id_manufacturer']) and $_POST['id_manufacturer'] == 0){
			$shop = new shop();
			$name_manufacturer = trim(sanitizeInput($_POST['name_manufacturer']));
			$notes_manufacturer = trim(sanitizeInput($_POST['notes_manufacturer']));
			$destino = "admin-shopmanufacturer";

			if ($shop->insertManufacturer($name_manufacturer, $notes_manufacturer)){ 
				$id = connection::SelectMaxReg("id_manufacturer", "shop_manufacturers", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$destino = "admin-shopmanufacturer?id=".$id;		
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
				
			redirectURL($destino);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_manufacturer']) and $_POST['id_manufacturer'] > 0){
			$shop = new shop();
			$id_manufacturer = trim(sanitizeInput($_POST['id_manufacturer']));
			$name_manufacturer = trim(sanitizeInput($_POST['name_manufacturer']));
			$notes_manufacturer = trim(sanitizeInput($_POST['notes_manufacturer']));
			$destino = "admin-shopmanufacturer";

			//actualizar fabricante
			if ($shop->updateManufacturer($id_manufacturer, $name_manufacturer, $notes_manufacturer))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			$destino = "admin-shopmanufacturer?id=".$id_manufacturer;

			redirectURL($destino);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$shop = new shop();
			if ($shop->updateManufacturerState($_REQUEST['id'], 0)) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-shopmanufacturers");
		}
	}
}
?>