<?php

class infoController{
	public static function getListAction($reg = 0, $filter = ""){
		$info = new info();
		$filtro = $filter." ORDER BY titulo_info";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("info i",$filtro); 
		return array('items' => $info->getInfo($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$info = new info();
		return $info->getInfo(" AND id_info=".$id);
	}	

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$info = new info();
			$download = ($_POST['download'] == "on" ? 1 : 0);

		  	if ($download == 1){
				//SUBIR FICHERO
				$nombre_archivo = time().'_'.str_replace(" ","_",$_FILES['info_file']['name']);
				$nombre_archivo = strtolower($nombre_archivo);
				$nombre_archivo = NormalizeText($nombre_archivo);

				if (!move_uploaded_file($_FILES['info_file']['tmp_name'], PATH_INFO.$nombre_archivo)){
					session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
					redirectURL("admin-info-doc?act=new");
				}
		  	}
		  	else{
		  		$nombre_archivo = $_POST['info_url'];
		  	}			

			if ($info->insertInfo($nombre_archivo, $_POST['info_title'], $_POST['info_canal'], $_POST['info_tipo'], $_POST['info_campana'], $download)){
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
				$id = connection::SelectMaxReg("id_info","info","");
				redirectURL("admin-info-doc?act=edit&id=".$id);
			}
			else {
				session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo generarse el registro.", "alert alert-danger");
				redirectURL("admin-info-doc?act=new");
			}
		}
	}

	public static function updateAction($id){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$info = new info();
			$download = ($_POST['download'] == "on" ? 1 : 0);

		  	if ($download == 1){
				if ($_FILES['info_file']['name'] != '') {
					$nombre_archivo = time().'_'.str_replace(" ", "_", $_FILES['info_file']['name']);
					$nombre_archivo = strtolower($nombre_archivo);
					$nombre_archivo = NormalizeText($nombre_archivo);	
					if (move_uploaded_file($_FILES['info_file']['tmp_name'], PATH_INFO.$nombre_archivo)){
						$info->updateInfoDoc($_POST['id'], $nombre_archivo);
					}
					else{
						session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
					}
				}
		  	}
		  	else{
		  		$info->updateInfoDoc($_POST['id'], $_POST['info_url']);
		  	}

			if ($info->updateInfo($_POST['id'], $_POST['info_title'], $_POST['info_canal'], $_POST['info_tipo'], $_POST['info_campana'], $download)) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("admin-info-doc?act=edit&id=".$id);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') {
			$info = new info();
			if ($info->deleteInfo($_REQUEST['id'], $_REQUEST['d'])) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("admin-info");
		}
	}

	public static function getZipAction(){
		if (isset($_REQUEST['exp']) and $_REQUEST['exp'] != ""){
			fileToZip($_REQUEST['exp'], PATH_INFO);
		}
	}	

	public static function insertAlerts(){
		$info = new info();
		$info -> insertAlerts();
	}
	
	public static function getAlerts(){
		$info = new info();
		$noLeidos = connection::countReg("info", " AND id_info NOT IN (SELECT id_info FROM info_alerts WHERE username_alert = '".$_SESSION['user_name']."')");
		return $noLeidos;
	}		
}
?>