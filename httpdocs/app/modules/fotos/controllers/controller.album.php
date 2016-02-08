<?php
class fotosAlbumController{
	public static function getItemAction($id){
		$fotos = new fotos();
		return $fotos->getFotosAlbumes(" AND id_album=".$id." ");
	}
	
	public static function getListAction($reg = 0, $filter = ""){
		$fotos = new fotos();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("galeria_fotos_albumes",$filter); 
		return array('items' => $fotos->getFotosAlbumes($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$fotos = new fotos();
			if ($fotos->InsertAlbum($_POST['nombre'], $_SESSION['user_name'])) {
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id_album = connection::SelectMaxReg("id_album","galeria_fotos_albumes"," AND activo=1 ");
				redirectURL("admin-albumes-new?id=".$id_album);
			}
			else{
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");
				redirectURL("admin-albumes-new");
			}
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$fotos = new fotos();
			if ($fotos->updateAlbum($_POST['id'], $_POST['nombre'], $_SESSION['user_name'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes-new?id=".$_POST['id']);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$fotos = new fotos();
			if ($fotos->cambiarEstadoAlbum($_REQUEST['id'], 0))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes");
		}
	}

	public static function downloadAction(){
		if ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) and (isset($_REQUEST['export']) and $_REQUEST['export'] == true)){
			$fotos = new fotos();
			$elements = $fotos->getFotos(" AND id_album=".$_REQUEST['id']." AND estado=1 ");
			$files = array();
			$i = 0;
			foreach($elements as $element):
				$files[$i][0] = PATH_FOTOS;
				$files[$i][1] = $element['name_file'];
				$i++;
			endforeach;
			filesToZip($files);
		}
	}

	public static function cancelFotoAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'foto_ko'){
			$fotos = new fotos();
			if ($fotos->cambiarEstado($_REQUEST['idf'], 2, 0))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes-new?id=".$_REQUEST['id']);
		}
	}

	public static function addFotoAction(){
		if (isset($_POST['file_id'])){
			$fotos = new fotos();
			if ($fotos->updateFotoAlbum($_POST['file_id'], $_POST['id_album']))
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-warning");
			
			redirectURL("admin-albumes-new?id=".$_POST['id_album']);
		}
	}
}
?>