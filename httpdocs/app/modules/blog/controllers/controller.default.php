<?php
class blogController{
	public static function getItemAction($id){
		$foro = new foro();
		$elements = $foro->getTemas(" AND id_tema=".$id." ");
		if (!isset($elements[0])){
			$elements[0]['nombre'] = "";
			$elements[0]['descripcion'] = "";
			$elements[0]['tipo_tema'] = "";
			$elements[0]['canal'] = "";
			$elements[0]['destacado'] = 0;
		}
		return $elements[0];
	}

	public static function getLastBlogAction($filtro_blog){
		$foro = new foro();
		$filtro_tema = "";
		$tema = array();
		if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) $id_tema = intval($_REQUEST['id']);
		elseif (isset($_REQUEST['f']) && $_REQUEST['f'] > 0) $id_tema = intval($_REQUEST['f']);
		else $id_tema = connection::SelectMaxReg("id_tema", "foro_temas", $filtro_blog." AND ocio=1 AND id_tema_parent=0 AND activo=1 ");

		if ($id_tema > 0){
			$filtro_tema .= " AND id_tema=".$id_tema." AND activo=1 AND ocio=1 ";
			$tema = $foro->getTemas($filtro_tema); 
		}

		$tema[0]['num_visitas'] = connection::countReg("foro_visitas", " AND id_tema=".$tema[0]['id_tema']." ");
		return $tema[0];
	}

	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0){
			$foro = new foro();
			$id = 0;
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput(stripslashes($_POST['descripcion']));
			$destacado = (isset($_POST['destacado']) && $_POST['destacado'] == "on") ? 1 : 0;
			$etiquetas = sanitizeInput($_POST['etiquetas']);
			$canal = sanitizeInput($_POST['canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			$file_info = pathinfo($_FILES['imagen-tema']['name']);
			$extension = strtolower($file_info['extension']);

			if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $_FILES['imagen-tema']['name'] == ''){
				if ($foro->InsertTema(0, $nombre, $descripcion, $_FILES['imagen-tema'], $_SESSION['user_name'], $canal, 0, 1, '', 0, 1, $etiquetas, $destacado )) {
					$id = connection::SelectMaxReg("id_tema", "foro_temas", " AND ocio=1 ");
					session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				}else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', "Extensión no valida: ".$extension, "alert alert-warning");

			redirectURL("admin-blog-new?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) && $_POST['id'] > 0){
			$id = intval($_POST['id']);
			$foro = new foro();	
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput(stripslashes($_POST['descripcion']));
			$destacado = (isset($_POST['destacado']) && $_POST['destacado'] == "on") ? 1 : 0;
			$etiquetas = sanitizeInput($_POST['etiquetas']);
			$canal = sanitizeInput($_POST['canal']);
			if (is_array($canal)) $canal = implode(",", $canal);
			
			$file_info = pathinfo($_FILES['imagen-tema']['name']);
			$extension = strtolower($file_info['extension']);

			if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $_FILES['imagen-tema']['name'] == ''){
				if ($foro->updateTemaBlog($id, $nombre, $descripcion, $etiquetas, $_FILES['imagen-tema'], $destacado, $canal)) {
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				}
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', "Extensión no valida: ".$extension, "alert alert-warning");

			redirectURL("admin-blog-new?id=".$id);
		}
	}

	public static function insertAlerts(){
		$blog = new blog();
		$blog -> insertAlerts();
	}
	
	public static function getAlerts(){
		$blog = new blog();
		$filtro_canal = ($_SESSION['user_perfil'] == 'admin' ? "" : " AND canal='".$_SESSION['user_canal']."' ");
		$noLeidos = connection::countReg("foro_temas", " AND activo=1 AND ocio=1 ".$filtro_canal." AND id_tema NOT IN (SELECT id_tema FROM blog_alerts WHERE username_alert = '".$_SESSION['user_name']."')");
		return $noLeidos;
	}

	public static function getCommentsAction(){
		$foro = new foro();
		$calculo = strtotime("-4 days");
		$fecha_ayer = date("Y-m-d", $calculo);
		$id = intval($_REQUEST['id']);
		return $foro->getComentarios(" AND c.estado=1 AND c.id_tema=".$id." ORDER BY id_comentario DESC");
	}

	public static function exportCommentsAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$foro = new foro();
			$id = intval($_REQUEST['id']);
			$elements_exp = $foro->getComentariosExport(" AND c.estado=1 AND c.id_tema=".$id." ");
			download_send_headers("data_".date("Y-m-d").".csv");
			echo array2csv($elements_exp);
			die();
		}
	}

	public static function validateCommentsAction(){
		if (isset($_REQUEST['act'])){
			$foro = new foro();
			$users = new users();
			$id = intval($_REQUEST['id']);
			$idt = intval($_REQUEST['idt']);
			$u = sanitizeInput($_REQUEST['u']);
			if ($_REQUEST['act'] == 'foro_ok'){
				if ($foro->cambiarEstado($id,1)){
					$users->sumarPuntos($u, PUNTOS_FORO, PUNTOS_FORO_MOTIVO);
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				}
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			elseif ($_REQUEST['act'] == 'tema_ko') {
				if ($foro->cambiarEstadoTema($id, 0))
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			elseif ($_REQUEST['act'] == 'foro_ko'){
				if ($foro->cambiarEstado($id, 2)){
					$users->restarPuntos($u, PUNTOS_MURO, PUNTOS_MURO_MOTIVO);
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				}
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			redirectURL("admin-blog-foro?id=".$idt);
		}
	}

	public static function exportListAction($filter = ""){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$foro = new foro();
			$elements = $foro->getTemas($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function cambiarEstadoAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$foro = new foro();	
			if ($foro->cambiarEstadoTema(intval($_REQUEST['id']), 0)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-blog");
		}
	}	
}
?>