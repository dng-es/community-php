<?php
class promocionesController{
	public static function getItemAction($id){
		$promociones = new promociones();
		return $promociones->getPromociones(" AND id_promocion=".$id." ");
	}

	public static function getListAction($reg = 0, $filter = ""){
		$promociones = new promociones();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND nombre_promocion LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY id_promocion DESC ";

		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("promociones", $filter);
		return array('items' => $promociones->getPromociones($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getLastPromocionAction($filter){
		$promociones = new promociones();
		$filter = "";
		$promocion = array();
		if (isset($_REQUEST['idp']) && $_REQUEST['idp'] > 0) $id_promocion = intval($_REQUEST['idp']);
		elseif (isset($_REQUEST['f']) && $_REQUEST['f'] > 0) $id_promocion = intval($_REQUEST['f']);
		else $id_promocion = connection::SelectMaxReg("id_promocion", "promociones", $filter." AND active=1 ");

		if ($id_promocion > 0){
			$filter .= " AND id_promocion=".$id_promocion." AND active=1 ";
			$promocion = $promociones->getPromociones($filter);
		}

		return $promocion[0];
	}

	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0){
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
		if (isset($_POST['id']) && $_POST['id'] > 0){
			$promociones = new promociones();
			$id = intval($_POST['id']);
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

			if ($promociones->updatePromociones($id, sanitizeInput($_POST['nombre_promocion']), sanitizeInput(stripslashes($_POST['texto_promocion'])), $galeria_videos, $galeria_fotos, $galeria_comentarios)){
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-promociones-new?id=".$id);
		}
	}

	public static function activeAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$promociones = new promociones();
			if ($promociones->updateActive(intval($_REQUEST['id']), intval($_REQUEST['idd']))) {
					//desactivar resto de registros
				if (sanitizeInput($_REQUEST['idd']) == 1) $promociones->updateActiveTodos(0 , " AND id_promocion<>".intval($_REQUEST['id'])." ");
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-promociones");
		}
	}
}
?>