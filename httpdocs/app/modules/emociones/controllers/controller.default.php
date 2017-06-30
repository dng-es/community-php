<?php
class emocionesController{
	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0){
			$emociones = new emociones();
			$info_title = sanitizeInput($_POST['info_title']);
			$resultado=$emociones->insertEmocion($_FILES['info_file'], $info_title);
			if ($resultado == 0){
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
				$id = connection::SelectMaxReg("id_emocion","emociones","");
				redirectURL("?page=admin-emocion&act=edit&id=".$id);
			}
			elseif ($resultado == 1){
				session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo generarse el registro.", "alert alert-danger");
				redirectURL("?page=admin-emocion&act=new");
			}
			elseif ($resultado == 2){
				session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
				redirectURL("?page=admin-emocion&act=new");
			}
		}
	}

	public static function updateAction($id){
		if (isset($_POST['id']) && $_POST['id'] > 0){
			$emociones = new emociones();
			if ($emociones->updateEmocion($id, $_FILES['info_file'], $_POST['info_title'])) {
				session::setFlashMessage('actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage('actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-emocion&act=edit&id=".$id);
		}
	}

	public function getItemAction($id){
		if (isset($_GET['act']) && $_GET['act'] == 'edit'){
			$emociones = new emociones();
			return $emociones->getEmociones(" AND id_emocion=".$id);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del') {
			$emociones = new emociones();
			$id = intval($_REQUEST['id']);
			if ($emociones->disableEmociones($id)) {
				session::setFlashMessage( 'actions_message', "emoción eliminada correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al eliminar emoción.", "alert alert-danger");
			}
			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
			redirectURL("?page=admin-emociones&pag=".$pag."&f=".$find_reg);
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

	public static function createUserAction(){
		if (isset($_POST['id_emocion']) && $_POST['id_emocion'] == ""){
			session::setFlashMessage( 'actions_message', "debes elegir una emoción.", "alert alert-danger");
			redirectURL("?page=home");
		}
		elseif (isset($_POST['mi_emocion']) && trim($_POST['mi_emocion']) == ""){
			session::setFlashMessage( 'actions_message', "debes explicar por qué te sientes así", "alert alert-danger");
			redirectURL("?page=home");
		}
		elseif (isset($_POST['id_emocion']) && $_POST['id_emocion'] != ""){
			$emociones = new emociones();
			if ($emociones->insertEmocionUser($_POST['id_emocion'], $_SESSION['user_name'], $_POST['mi_emocion'])){
				//verificar si el usuario esta en postformacion para mostrarle un mensaje aleatorio
				$mensaje = "";
				$users = new users();
				$usuario = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
				if ($usuario[0]['postformacion'] == 1){
					$consejos = $emociones->getEmocionesConsejos(" AND id_emocion=".$_POST['id_emocion']." ORDER BY rand(" . time() . " * " . time() . ") LIMIT 1");
					$mensaje = '<br /><br /><b>'.$consejos[0]['emocion_consejo'].'</b>';
				}

				session::setFlashMessage('actions_message', "emoción insertada correctamente - <b>".$_POST['name_emocion'].":</b> ".$_POST['mi_emocion'].$mensaje, "");
				$id = connection::SelectMaxReg("id_emocion", "emociones","");
			}
			else{
				session::setFlashMessage('actions_message', "ocurrió algún error enviar la emoción.", "alert alert-danger");
			}
			redirectURL("?page=home");
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
			download_send_headers("emociones_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}	
	}
}
?>