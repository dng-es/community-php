<?php
class fotosController{
	public static function getListAction($reg = 0, $filter = ""){
		$fotos = new fotos();
		$find_reg = ((isset($_REQUEST['f']) and $_REQUEST['f'] != 'null') ? $_REQUEST['f'] : (isset($_POST['find_reg']) ? $_POST['find_reg'] : ""));
		if ($find_reg != "" ) $filter .= " AND titulo LIKE '%".sanitizeInput($find_reg)."%' ".$filter;
		//if ($_SESSION['user_canal'] != 'admin') $filter = " AND f.canal='".$_SESSION['user_canal']."' ".$filter;
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("galeria_fotos f", $filter); 
		return array('items' => $fotos->getFotos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($filter){
		$fotos = new fotos();
		$elements = $fotos->getFotos($filter);
		return $elements[0];
	}

	public static function createAction(){
		if (isset($_POST['titulo-foto']) and $_POST['titulo-foto'] != ""){
			$fotos = new fotos();	
			$canal = (($_SESSION['user_canal'] != 'admin') ? $_SESSION['user_canal'] : $_POST['canal-foto']);
			$id_promocion = ((isset($_POST['id_promocion']) and $_POST['id_promocion'] > 0) ? intval($_POST['id_promocion']) : 0);
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
		if (isset($_REQUEST['idvf']) and $_REQUEST['idvf'] != ""){
			$destination .= (strpos($destination, "?") == 0  ? "?1=1" : "");
			$fotos = new fotos();
			$response = $fotos->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);
			if ($response == 1)
				$message = strTranslate("Photo_vote_ok");
			elseif ($response == 2)
				$message = strTranslate("Photo_vote_repeat");
			elseif ($response == 3)
				$message = strTranslate("Photo_vote_own");

			if (isset($_REQUEST['f']) and $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag']) and $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];
			if (isset($_REQUEST['id']) and $_REQUEST['id'] != "") $destination .= "&id=".$_REQUEST['id'];

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