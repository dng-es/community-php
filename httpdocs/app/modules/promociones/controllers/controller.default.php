<?php
class promocionesController{
	public static function getItemAction($id){
		$promociones = new promociones();
		return $promociones->getPromociones(" AND id_promocion=".$id." ");
	}

	public static function getListAction($reg = 0, $filtro = ""){
		$promociones = new promociones();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND nombre_promocion LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND nombre_promocion LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY id_promocion DESC ";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("promociones",$filtro);
		return array('items' => $promociones->getPromociones($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getLastPromocionAction($filtro_promocion){
		$promociones = new promociones();
		$filtro_promocion = "";
		$promocion = array();
		if (isset($_REQUEST['idp']) and $_REQUEST['idp'] > 0) $id_promocion = $_REQUEST['idp'];
		elseif (isset($_REQUEST['f']) and $_REQUEST['f'] > 0) $id_promocion = $_REQUEST['f']; 
		else $id_promocion = connection::SelectMaxReg("id_promocion", "promociones", $filtro_promocion." AND active=1 ");

		if ($id_promocion > 0){
			$filtro_promocion .= " AND id_promocion=".$id_promocion." AND active=1 ";
			$promocion = $promociones->getPromociones($filtro_promocion); 
		}

		return $promocion[0];
	}	

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$promociones = new promociones();
			$id = 0;

			if ($_POST['galeria_promocion'] == 'videos'){
				$galeria_videos = 1;
				$galeria_fotos = 0;
				$galeria_comentarios = 0;
			}
			elseif ($_POST['galeria_promocion'] == 'fotos'){
				$galeria_videos = 0;
				$galeria_fotos = 1;
				$galeria_comentarios = 0;
			}
			else{
				$galeria_videos = 0;
				$galeria_fotos = 0;
				$galeria_comentarios = 1;
			}

			if ($promociones->insertPromociones(sanitizeInput($_POST['nombre_promocion']), sanitizeInput(stripslashes($_POST['texto_promocion'])), 0, $galeria_videos, $galeria_fotos, $galeria_comentarios)) {
				$id = connection::SelectMaxReg("id_promocion", "promociones", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}else 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-danger");

			redirectURL("admin-promociones-new?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$promociones = new promociones();	
			if ($_POST['galeria_promocion'] == 'videos'){
				$galeria_videos = 1;
				$galeria_fotos = 0;
				$galeria_comentarios = 0;
			}
			elseif ($_POST['galeria_promocion'] == 'fotos'){
				$galeria_videos = 0;
				$galeria_fotos = 1;
				$galeria_comentarios = 0;
			}
			else{
				$galeria_videos = 0;
				$galeria_fotos = 0;
				$galeria_comentarios = 1;
			}

			if ($promociones->updatePromociones(sanitizeInput($_POST['id']), sanitizeInput($_POST['nombre_promocion']), sanitizeInput(stripslashes($_POST['texto_promocion'])), $galeria_videos, $galeria_fotos, $galeria_comentarios)) {
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}	
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-promociones-new?id=".$_POST['id']);
		}
	}

	public static function activeAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$promociones = new promociones();	

			
			if ($promociones->updateActive(sanitizeInput($_REQUEST['id']), sanitizeInput($_REQUEST['idd']))) {
					//desactivar resto de registros
				if (sanitizeInput($_REQUEST['idd']) == 1) $promociones->updateActiveTodos(0 , " AND id_promocion<>".sanitizeInput($_REQUEST['id'])." ");
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}	
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-promociones");
		}
	}	
}
?>