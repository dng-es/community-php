<?php
class videosController{
	public static function getItemAction($id = 0, $filter = ""){
		$item = array();
		if ($id != 0){
			$videos = new videos();
			$item = $videos->getVideos($filter." AND id_file=".$id);
		}
		return $item[0];
	}

	public static function getListAction($reg = 0, $filter = ""){
		$videos = new videos();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND titulo LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY id_file DESC";

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("galeria_videos v, users u", " AND u.username=v.user_add ".$filter);
		return array('items' => $videos->getVideos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['titulo-video']) && $_POST['titulo-video'] != ""){
			$videos = new videos();	
			$canal = (($_SESSION['user_canal'] != 'admin') ? $_SESSION['user_canal'] : $_POST['canal-video']);
			$id_promocion = ((isset($_POST['id_promocion']) && $_POST['id_promocion'] > 0) ? sanitizeInput($_POST['id_promocion']) : 0);
			$etiquetas = (isset($_POST['etiquetas']) ? strtolower(sanitizeInput($_POST['etiquetas'])) : '');
			$titulo = (isset($_POST['titulo-video']) ? sanitizeInput($_POST['titulo-video']) : '');
			$response = $videos->insertFile($_FILES['nombre-video'], PATH_VIDEOS_TEMP, $canal, $titulo, $id_promocion, 0, $etiquetas);
			if ($response == 0)
				session::setFlashMessage('actions_message', strTranslate("Video_upload_ko0"), "alert alert-warning");
			elseif ($response == 1)
				session::setFlashMessage('actions_message', strTranslate("Video_upload_ok"), "alert alert-success");
			elseif ($response == 2)
				session::setFlashMessage('actions_message', strTranslate("Video_upload_ko1"), "alert alert-warning");
			elseif ($response == 3)
				session::setFlashMessage('actions_message', strTranslate("Video_upload_ko2"), "alert alert-warning");
		
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function voteAction($destination = "videos"){
		if (isset($_REQUEST['idvv']) && $_REQUEST['idvv'] != ""){
			$videos = new videos();
			$response = $videos->InsertVotacion($_REQUEST['idvv'], $_SESSION['user_name']);
			if ($response == 1)
				session::setFlashMessage('actions_message', strTranslate("Video_vote_ok"), "alert alert-success");
			elseif ($response == 2)
				session::setFlashMessage('actions_message', strTranslate("Video_vote_repeat"), "alert alert-warning");
			elseif ($response == 3)
				session::setFlashMessage('actions_message', strTranslate("Video_vote_own"), "alert alert-warning");

			if (isset($_REQUEST['f']) && $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag']) && $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];

			redirectURL($destination."?id=".$_REQUEST['idvv']);
		}
	}

	public static function downloadZipFile($path = PATH_VIDEOS_TEMP){
		if (isset($_REQUEST['exp']) && $_REQUEST['exp'] != "") fileToZip($_REQUEST['exp'], $path);
	}	

	public static function adminActions(){
		if (isset($_REQUEST['act'])) {
			$users = new users();
			$videos = new videos();
			if ($_REQUEST['act']=='video_ok'){
				if (copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4", PATH_VIDEOS.$_REQUEST['f'].".mp4")){
					copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg", PATH_VIDEOS.$_REQUEST['f'].".mp4.jpg");
					//unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
					unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
					//unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
					$videos->cambiarEstado($_REQUEST['id'], 1);
					$videos->cambiarNombre($_REQUEST['id']);
					$videos->cambiarTags($_REQUEST['id'], strtolower(sanitizeInput($_REQUEST['tags'])));
					$users->sumarPuntos($_REQUEST['u'], PUNTOS_VIDEO, PUNTOS_VIDEO_MOTIVO);
				}
				else session::setFlashMessage('actions_message', "No se ha podido validar el video.", "alert alert-warning"); 
			}
			elseif ($_REQUEST['act'] == 'video_conv') {
				$videos->convertirVideo($_REQUEST['f'], PATH_VIDEOS_TEMP, PATH_VIDEOS_CONVERT);
				session::setFlashMessage('actions_message', "Conversión finalizada.", "alert alert-success");
			}
			elseif ($_REQUEST['act'] == 'video_ko'){
				unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
				unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
				unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
				if ($videos->cambiarEstado($_REQUEST['id'], 2)) 
					session::setFlashMessage('actions_message', "Video cancelado correctamente.", "alert alert-success");
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}

			redirectURL("admin-validacion-videos");
		}
	}

	///////////////////////////////////////////////////////////////////////////
	/// VIDEO COMMENTS
	///////////////////////////////////////////////////////////////////////////

	public static function getCommentsListAction($reg = 0, $filter = ""){
		$videos = new videos();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND comentario LIKE '%".$find_reg."%' ";

		$paginator_items = self::PaginatorPagesVideoComments($reg);
		$total_reg = connection::countReg("galeria_videos_comentarios", $filter);
		return array('items' => $videos->getComentariosVideo($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createCommentAction(){
		if (isset($_POST['video-comentario']) && trim($_POST['video-comentario']) != ""){
			$videos = new videos();
			$id_video = sanitizeInput($_POST['video-id']);
			$texto_comentario = nl2br(sanitizeInput($_POST['video-comentario']));
			if ($videos->InsertComentario($id_video, $texto_comentario, $_SESSION['user_name'],1)){
				session::setFlashMessage('actions_message', strTranslate("Video_comment_insert_ok"), "alert alert-success");
				notificationsController::insertNotifications($id_video, 'videos');
			} 
			else 
				session::setFlashMessage('actions_message', strTranslate("Video_comment_insert_ko"), "alert alert-warning");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function validateCommentAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'elem_ko'){
			$videos = new videos();
			$videos->cambiarEstadoComentario($_REQUEST['idc'], 2);

			session::setFlashMessage('actions_message', "Comentario cancelado", "alert alert-warning");
			redirectURL("admin-videos-comentarios?id=".$_REQUEST['id']);
		}
	}

	public static function voteCommentAction($destination = "videos"){
		if (isset($_REQUEST['idvc']) && $_REQUEST['idvc'] != ""){
			$videos = new videos();
			$response = $videos->InsertVotacionVideo($_REQUEST['idvc'],$_SESSION['user_name']);
			if ($response == 1)
				$message = strTranslate("Video_comment_vote_ok");
			elseif ($response == 2)
				$message = strTranslate("Video_comment_vote_repeat");
			elseif ($response == 3)
				$message = strTranslate("Video_comment_vote_own");

			if (isset($_REQUEST['f']) && $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag2']) && $_REQUEST['pag2'] != "") $destination .= "&pag2=".$_REQUEST['pag2'];

			session::setFlashMessage('actions_message', $message, "alert alert-warning");
			redirectURL($destination);
		}
	}

	/**
	 * Funcion para obtener variables del paginador
	 * @param 	int 		$reg 			Número de registros por página
	 */
	public static function PaginatorPagesVideoComments($reg){
		$find_reg = getFindReg();
		$pag = 1;
		$inicio = 0;
		if (isset($_GET["pag2"]) && $_GET["pag2"] != ""){
			$pag = $_GET["pag2"];
			$inicio = ($pag - 1) * $reg;
		}
		return array('find_reg' => $find_reg,
					'pag' => $pag,
					'inicio' => $inicio,
					'find_reg' => $find_reg);
	}

	public static function changeEstado(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$videos = new videos();
			if ($videos->cambiarEstado(intval($_REQUEST['id']), 2))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-videos");
		}
	}

	public static function changeTags(){
		if (isset($_REQUEST['tags'])){
			$videos = new videos();
			$id_file = sanitizeInput($_REQUEST['idf']);
			$pag = sanitizeInput($_REQUEST['pag']);
			$tags = strtolower(sanitizeInput($_REQUEST['tags']));
			$destacado = intval($_REQUEST['dest']);
			if ($videos->cambiarTags($id_file, $tags, $destacado))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-warning");

			redirectURL("admin-videos?pag=".$pag);
		}
	}

	public static function exportListAction($filter = ''){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$videos = new videos();
			$elements = $videos->getVideos($filter);
			download_send_headers("videos_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}			
}
?>