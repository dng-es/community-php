<?php
class emocionesController{
	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0){
			$emociones = new emociones();
			$info_title = sanitizeInput($_POST['info_title']);
			$resultado = $emociones->insertEmocion($_FILES['info_file'], $info_title);
			if ($resultado == 0){
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
				$id = connection::SelectMaxReg("id_emocion","emociones","");
				redirectURL("?page=admin-emocion&act=edit&id=".$id);
			}
			elseif ($resultado == 1){
				session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo generarse el registro.", "alert alert-danger");
				redirectURL("?page=admin-emocion&act=new");
			}
			elseif ($resultado == 2){
				session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
				redirectURL("admin-emocion?id=".$id);
			}
		}
	}

	public static function updateAction($id){
		if (isset($_POST['id']) && $_POST['id'] > 0){
			$emociones = new emociones();
			$id = intval($_POST['id']);
			if ($emociones->updateEmocion($id, $_FILES['info_file'], $_POST['info_title'])) 
				session::setFlashMessage('actions_message', "Registro modificado correctamente", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-emocion?id=".$id);
		}
	}

	public function getItemAction($id){
		if ($id > 0){
			$emociones = new emociones();

			$result = $emociones->getEmociones(" AND id_emocion=".$id);

			if (!isset($result[0])){
				$result[0]['name_emocion'] = "";
				$result[0]['desc_emocion'] = "";
				$result[0]['image_emocion'] = "";
			}

			return $result[0];
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del') {
			$emociones = new emociones();
			$id = intval($_REQUEST['id']);
			if ($emociones->disableEmociones($id)) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
			redirectURL("admin-emociones?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function getListAction($reg = 0, $filter = ""){
		$emociones = new emociones();
		$filter .= " ORDER BY id_emocion ASC ";
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("emociones", $filter);
		return array('items' => $emociones->getEmociones($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListConsejosAction($reg = 0, $filter = ""){
		$emociones = new emociones();
		$filter .= " ORDER BY id_emocion ASC ";
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("emociones_consejos", $filter);
		return array('items' => $emociones->getEmocionesConsejos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}	

	public static function createUserAction($destination = "emociones-home"){
		if (isset($_POST['id_emocion']) && $_POST['id_emocion'] == ""){
			session::setFlashMessage('actions_message', "Debes elegir una emoción.", "alert alert-danger");
			redirectURL($destination);
		}
		elseif (isset($_POST['mi_emocion']) && trim($_POST['mi_emocion']) == ""){
			session::setFlashMessage('actions_message', "Debes explicar por qué te sientes así", "alert alert-danger");
			redirectURL($destination);
		}
		elseif (isset($_POST['id_emocion']) && $_POST['id_emocion'] != ""){
			$emociones = new emociones();
			$name_emocion = sanitizeInput($_POST['name_emocion']);
			$mi_emocion = sanitizeInput($_POST['mi_emocion']);
			$id_emocion = intval($_POST['id_emocion']);
			if ($emociones->insertEmocionUser($_POST['id_emocion'], $_SESSION['user_name'], $mi_emocion)){
				$mensaje = "";

				//obtener consejo para la emoción
				$consejos = $emociones->getEmocionesConsejos(" AND id_emocion=".$id_emocion." ORDER BY rand(" . time() . " * " . time() . ") LIMIT 1");
				if (isset($consejos[0]['emocion_consejo'])) $mensaje = $consejos[0]['emocion_consejo'];

				session::setFlashMessage('actions_message', $mensaje, "alert alert-info", $name_emocion);
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL($destination);
		}
	}

	public static function getListuserAction($reg = 0, $filter = ""){
		$emociones = new emociones();
		$find_reg = getFindReg();
		if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0){
			$filter .= " AND eu.id_emocion=".$_REQUEST['id'] . " " .$filter;
		}
		if (isset($_REQUEST['i']) && $_REQUEST['i'] != ""){
			$filter .= " AND date_emocion BETWEEN " . str_replace("%27", "'", $_REQUEST['i']) . " " .$filter;
		}
		$filter .= " ORDER BY date_emocion DESC ";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("emociones_user eu", $filter);
		return array('items' => $emociones->getEmocionesUser($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListUserAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$emociones = new emociones();
			$elements = $emociones->getEmocionesUser("");
			download_send_headers(strTranslate("Emotions")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}	
	}

	public static function createConsejoAction(){
		if (isset($_POST['id_emocion']) && $_POST['id_emocion'] > 0){
			$emociones = new emociones();
			$id_emocion = intval($_POST['id_emocion']);
			$emocion_consejo = sanitizeInput($_POST['emocion_consejo']);
			if ($emociones->insertConsejoEmocionUser($id_emocion, $emocion_consejo))
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			
			redirectURL("admin-emocion?id=".$id_emocion);
			
		}
	}	

	public static function deleteConsejoAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del') {
			$emociones = new emociones();
			$id = intval($_REQUEST['id']);
			$idc = intval($_REQUEST['idc']);
			if ($emociones->deleteConsejoEmociones($idc)) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-emocion?id=".$id);
		}
	}
}
?>