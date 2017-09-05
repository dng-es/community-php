<?php
class fotosController{
	public static function getListAction($reg = 0, $filter = ""){
		$fotos = new fotos();
		$find_reg = getFindReg();
		if ($find_reg != "" && $find_reg != 'null') $filter = " AND titulo LIKE '%".sanitizeInput($find_reg)."%' ".$filter;
		//if ($_SESSION['user_canal'] != 'admin') $filter = " AND f.canal='".$_SESSION['user_canal']."' ".$filter;
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("galeria_fotos f, galeria_fotos_albumes a, users u", " AND f.id_album=a.id_album AND u.username=f.user_add ".$filter); 
		return array('items' => $fotos->getFotos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction($filter = ''){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$fotos = new fotos();
			$elements = $fotos->getFotos($filter);
			download_send_headers(strTranslate("Photos")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}	

	public static function getItemAction($filter){
		$fotos = new fotos();
		$elements = $fotos->getFotos($filter);
		return (isset($elements[0]) ? $elements[0] : null);;
	}

	public static function createAction(){
		if (isset($_POST['titulo-foto']) && $_POST['titulo-foto'] != ""){
			$fotos = new fotos();	
			$canal = (($_SESSION['user_canal'] != 'admin') ? $_SESSION['user_canal'] : $_POST['canal-foto']);
			$id_promocion = ((isset($_POST['id_promocion']) && $_POST['id_promocion'] > 0) ? intval($_POST['id_promocion']) : 0);
			$id_album = (isset($_POST['nombre_album']) ? intval($_POST['nombre_album']) : 0);
			$etiquetas = (isset($_POST['etiquetas']) ? strtolower(sanitizeInput($_POST['etiquetas'])) : '');
			$titulo = (isset($_POST['titulo-foto']) ? sanitizeInput($_POST['titulo-foto']) : '');
			$response = $fotos->insertFile($_FILES['nombre-foto'], PATH_FOTOS, $canal, $titulo, $id_promocion, 0, $etiquetas, $id_album);
			if ($response == 0)
				session::setFlashMessage('actions_message', strTranslate("Photo_upload_ko0"), "alert alert-danger");
			elseif ($response == 1)
				session::setFlashMessage('actions_message', strTranslate("Photo_upload_ok"), "alert alert-success");
			elseif ($response == 2)
				session::setFlashMessage('actions_message', strTranslate("Photo_upload_ko1"), "alert alert-danger");
			elseif ($response == 3)
				session::setFlashMessage('actions_message', strTranslate("Photo_upload_ko2"), "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function voteAction($destination = "fotos"){
		if (isset($_REQUEST['idvf']) && $_REQUEST['idvf'] != ""){
			$fotos = new fotos();
			$destination .= (strpos($destination, "?") == 0  ? "?1=1" : "");
			$response = $fotos->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);
			
			if ($response == 1) $message = strTranslate("Photo_vote_ok");
			elseif ($response == 2) $message = strTranslate("Photo_vote_repeat");
			elseif ($response == 3) $message = strTranslate("Photo_vote_own");

			if (isset($_REQUEST['f']) && $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag']) && $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") $destination .= "&id=".$_REQUEST['id'];

			session::setFlashMessage('actions_message', $message, "alert alert-warning");
			redirectURL($destination);
		}
	}

	public static function changeTags(){
		if (isset($_REQUEST['tags'])){
			$fotos = new fotos();
			$id_album = $_REQUEST['id'];
			$id_file = $_REQUEST['idf'];
			$tags = strtolower(sanitizeInput($_REQUEST['tags']));
			if ($fotos->cambiarTags($id_file, $tags))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes-new?act=edit&id=".$id_album);
		}
	}
}
?>