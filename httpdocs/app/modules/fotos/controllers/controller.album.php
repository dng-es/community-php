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

	public static function createAction($destination = "admin-albumes-new" ){
		if (isset($_POST['id']) && $_POST['id'] == 0){
			$nombre = sanitizeInput(trim($_POST['nombre']));
			$canal = (isset($_POST['canal_album']) ? $_POST['canal_album'] : $_SESSION['user_canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			$result = self::newAlbum($nombre, $canal);
			session::setFlashMessage('actions_message', $result['description'], "alert alert-".$result['message']);

			if ($result['message'] == "success"){
				$id_album = connection::SelectMaxReg("id_album","galeria_fotos_albumes"," AND activo=1 ");
				$destination .= "?id=".$id_album;
			}

			redirectURL($destination);
		}
	}

	public static function newAlbum($nombre, $canal){
		//verificar album en blanco
		if ($nombre == ''){
			$result['message'] = "warning";
			$result['description'] = "Introduce el nombre del album";
		}
		else{
			//verificar ya exista un album con el mismo nombre
			if (connection::countReg("galeria_fotos_albumes"," AND nombre_album='".$nombre."' AND activo=1 AND canal_album LIKE '%".$canal."%' ")){
				$result['message'] = "warning";
				$result['description'] = "Ya existe un album con el mismo nombre";
			}
			else{
				$fotos = new fotos();
				if ($fotos->InsertAlbum($nombre, $_SESSION['user_name'], $canal)) {
					$result['message'] = "success";
					$result['description'] = strTranslate("Insert_procesing");
				}
				else{
					$result['message'] = "warning";
					$result['description'] = strTranslate("Error_procesing");
				}
			}
		}
		return $result;
	}

	public static function updateAction(){
		if (isset($_POST['id']) && $_POST['id'] > 0){
			$fotos = new fotos();

			$id = intval($_POST['id']);
			$nombre = sanitizeInput(trim($_POST['nombre']));
			$canal = (isset($_POST['canal_album']) ? sanitizeInput($_POST['canal_album']) : $_SESSION['user_canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			if ($fotos->updateAlbum($id, $nombre, $_SESSION['user_name'], $canal)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes-new?id=".$_POST['id']);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$fotos = new fotos();
			if ($fotos->cambiarEstadoAlbum($_REQUEST['id'], 0))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes");
		}
	}

	public static function downloadAction(){
		if ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) && (isset($_REQUEST['export']) && $_REQUEST['export'] == true)){
			$fotos = new fotos();
			$id_album = intval($_REQUEST['id']);
			$elements = $fotos->getFotos(" AND f.id_album=".$id_album." AND estado=1 ");
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
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'foto_ko'){
			$fotos = new fotos();
			if ($fotos->cambiarEstado(intval($_REQUEST['idf']), 2, 0))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-albumes-new?id=".intval($_REQUEST['id']));
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