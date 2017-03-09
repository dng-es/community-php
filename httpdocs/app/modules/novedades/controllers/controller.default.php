<?php
class novedadesController{
	public static function getListAction($reg = 0, $filtro = ""){
		$novedades = new novedades();
		$paginator_items = PaginatorPages($reg);
		$find_reg = "";
		
		$total_reg = connection::countReg("novedades n",$filtro); 
		return array('items' => $novedades->getNovedades($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$novedades = new novedades();
		$element = array();
		$elements = $novedades->getNovedades(" AND id_novedad=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['titulo'] = "";
			$element['cuerpo'] = "";
			$element['canal'] = "";
			$element['perfil'] = "";
			$element['activo'] = 0;
			$element['tipo'] = "slider";
			$element['orden'] = 0;
		}

		return $element;
	}

	public static function createAction(){
		if (isset($_POST['id_novedad']) && $_POST['id_novedad'] == 0){
			$novedades = new novedades();
			$titulo = sanitizeInput($_POST['titulo']);
			$cuerpo = stripslashes($_POST['texto']);
			$perfil = sanitizeInput($_POST['perfil']);
			$tipo = sanitizeInput($_POST['tipo']);
			$activo = ($_POST['activo'] == "on" ? 1 : 0);
			$orden = intval(trim($_POST['orden']) == "" ? 0 : trim($_POST['orden']));
			$canal = sanitizeInput($_POST['canal']);
			if (is_array($canal)) $canal = implode(",", $canal);
			
			if ($novedades->insertNovedades($titulo, $cuerpo, $activo, $canal, $perfil, $tipo, $orden)){ 
				$id = connection::SelectMaxReg("id_novedad", "novedades", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-novedad?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_novedad']) && $_POST['id_novedad'] > 0){
			$novedades = new novedades();
			$id_novedad = intval($_POST['id_novedad']);
			$titulo = sanitizeInput($_POST['titulo']);
			$cuerpo = stripslashes($_POST['texto']);
			$perfil = sanitizeInput($_POST['perfil']);
			$tipo = sanitizeInput($_POST['tipo']);
			$activo = ($_POST['activo'] == "on" ? 1 : 0);
			$orden = intval(trim($_POST['orden']) == "" ? 0 : trim($_POST['orden']));
			$canal = sanitizeInput($_POST['canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			if ($novedades->updateNovedades($id_novedad, $titulo, $cuerpo, $activo, $canal, $perfil, $tipo, $orden)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-novedad?id=".$id_novedad);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$novedades = new novedades();
			$id_novedad = intval($_REQUEST['id']);
			
			if ($novedades->deleteNovedades($id_novedad))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-novedades");
		}
	}
}
?>