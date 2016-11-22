<?php
class blogController{
	public static function getItemAction($id){
		$foro = new foro();
		return $foro->getTemas(" AND id_tema=".$id." ");
	}

	public static function getLastBlogAction($filtro_blog){
		$foro = new foro();
		$filtro_tema = "";
		$tema = array();
		if (isset($_REQUEST['id']) and $_REQUEST['id'] > 0) $id_tema = $_REQUEST['id'];
		elseif (isset($_REQUEST['f']) and $_REQUEST['f'] > 0) $id_tema = $_REQUEST['f']; 
		else $id_tema = connection::SelectMaxReg("id_tema", "foro_temas", $filtro_blog." AND ocio=1 AND id_tema_parent=0 AND activo=1 ");

		if ($id_tema > 0){
			if ($_SESSION['user_canal'] != "admin") $filtro_tema = " AND (canal='".$_SESSION['user_canal']."' OR canal='admin') ";

			$filtro_tema .= " AND id_tema=".$id_tema." AND activo=1 AND ocio=1 ";
			$tema = $foro->getTemas($filtro_tema); 
		}

		$tema[0]['num_visitas'] = connection::countReg("foro_visitas", " AND id_tema=".$tema[0]['id_tema']." ");
		return $tema[0];
	}

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$foro = new foro();
			$id = 0;
			$destacado = (isset($_POST['destacado']) and $_POST['destacado'] == "on") ? 1 : 0;

			$file_info = pathinfo($_FILES['imagen-tema']['name']);
			$extension = strtolower($file_info['extension']);

			if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $_FILES['imagen-tema']['name'] == ''){			
				if ($foro->InsertTema(0, $_POST['nombre'], stripslashes($_POST['descripcion']), $_FILES['imagen-tema'], $_SESSION['user_name'], $_POST['canal'], 0, 1, '', 0, 1, $_POST['etiquetas'], $destacado )) {
					$id = connection::SelectMaxReg("id_tema", "foro_temas", " AND ocio=1 ");
					session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				}else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', "Extensión no valida: ".$extension, "alert alert-warning");

			redirectURL("admin-blog-new?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$foro = new foro();	
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput(stripslashes($_POST['descripcion']));
			$destacado = (isset($_POST['destacado']) and $_POST['destacado'] == "on") ? 1 : 0;
			
			$file_info = pathinfo($_FILES['imagen-tema']['name']);
			$extension = strtolower($file_info['extension']);

			if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $_FILES['imagen-tema']['name'] == ''){
				if ($foro->updateTema($_POST['id'], $nombre, $descripcion, $_POST['etiquetas'], $_FILES['imagen-tema'], $destacado)) {
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				}	
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', "Extensión no valida: ".$extension, "alert alert-warning");

			redirectURL("admin-blog-new?id=".$_POST['id']);
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
		$id_tema = $_REQUEST['id'];
		return $foro->getComentarios(" AND c.estado=1 AND c.id_tema=".$id_tema." ORDER BY id_comentario DESC");
	}

	public static function exportCommentsAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$foro = new foro(); 
			$elements_exp = $foro->getComentariosExport(" AND c.estado=1 AND c.id_tema=".$_REQUEST['id']." ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements_exp);
			die();
		}
	}

	public static function validateCommentsAction(){
		if (isset($_REQUEST['act'])){
			$foro = new foro();
			$users = new users();
			if ($_REQUEST['act'] == 'foro_ok'){
				$foro->cambiarEstado($_REQUEST['id'],1);
				$users->sumarPuntos($_REQUEST['u'], PUNTOS_FORO, PUNTOS_FORO_MOTIVO);
			}
			elseif ($_REQUEST['act'] == 'tema_ko') $foro->cambiarEstadoTema($_REQUEST['id'], 0);
			elseif ($_REQUEST['act'] == 'foro_ko'){
				$foro->cambiarEstado($_REQUEST['id'], 2);
				$users->restarPuntos($_REQUEST['u'], PUNTOS_MURO, PUNTOS_MURO_MOTIVO);
			}
			header("Location: admin-blog-foro?id=".$_REQUEST['idt']); 
		}
	}
}
?>