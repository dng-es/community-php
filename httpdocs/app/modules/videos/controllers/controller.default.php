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
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filter .= " AND titulo LIKE '%".$_POST['find_reg']."%' ";$find_reg = $_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filter .= " AND titulo LIKE '%".$_REQUEST['f']."%' ";$find_reg = $_REQUEST['f'];} 
		if ($_SESSION['user_canal'] != 'admin') $filter.=" AND v.canal='".$_SESSION['user_canal']."' ";
		$filter .= " ORDER BY id_file DESC";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("galeria_videos v",$filter); 
		return array('items' => $videos->getVideos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['titulo-video']) and $_POST['titulo-video']!=""){
			$videos = new videos();	
			$canal = (($_SESSION['user_canal'] != 'admin') ? $_SESSION['user_canal'] : $_POST['canal-video']);		
			$response = $videos->insertFile($_FILES['nombre-video'],PATH_VIDEOS_TEMP,$canal,$_POST['titulo-video'], 0, 0);
			if ($response == 0)
				session::setFlashMessage( 'actions_message', strTranslate("Video_upload_ko0"), "alert alert-warning");
			elseif ($response == 1)
				session::setFlashMessage( 'actions_message', strTranslate("Video_upload_ok"), "alert alert-success");
			elseif ($response == 2)
				session::setFlashMessage( 'actions_message', strTranslate("Video_upload_ko1"), "alert alert-warning");
			elseif ($response == 3)
				session::setFlashMessage( 'actions_message', strTranslate("Video_upload_ko2"), "alert alert-warning");
		
			redirectURL($_SERVER['REQUEST_URI']);
		}			
	}

	public static function voteAction($destination = "videos"){
		if (isset($_REQUEST['idvv']) and $_REQUEST['idvv'] != "") { 
			$videos = new videos();
			$response = $videos->InsertVotacion($_REQUEST['idvv'],$_SESSION['user_name']);
			if ($response == 1)
				session::setFlashMessage( 'actions_message', strTranslate("Video_vote_ok"), "alert alert-success");
			elseif ($response == 2)
				session::setFlashMessage( 'actions_message', strTranslate("Video_vote_repeat"), "alert alert-warning");
			elseif ($response == 3)
				session::setFlashMessage( 'actions_message', strTranslate("Video_vote_own"), "alert alert-warning");

			if (isset($_REQUEST['f']) and $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag']) and $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];

			redirectURL($destination."?id=".$_REQUEST['idvv']);
		}		
	}

	public static function downloadZipFile(){
		if (isset($_REQUEST['exp']) and $_REQUEST['exp'] != "") {	
			fileToZip($_REQUEST['exp'], PATH_VIDEOS_TEMP);
		}		
	}	

	///////////////////////////////////////////////////////////////////////////
	/// VIDEO COMMENTS
	///////////////////////////////////////////////////////////////////////////

	public static function getCommentsListAction($reg = 0, $filter = ""){
		$videos = new videos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filter = " AND comentario LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'].$filter;}
		if (isset($_REQUEST['f']) and $_REQUEST['f'] != "") $filter = " AND comentario LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'].$filter;
		$paginator_items = self::PaginatorPagesVideoComments($reg);
		
		$total_reg = connection::countReg("galeria_videos_comentarios", $filter);
		return array('items' => $videos->getComentariosVideo($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createCommentAction(){
		if (isset($_POST['video-comentario']) and trim($_POST['video-comentario']) != ""){
			$videos = new videos();
			$id_video = sanitizeInput($_POST['video-id']);
			$texto_comentario = nl2br(sanitizeInput($_POST['video-comentario']));
			if ($videos->InsertComentario($id_video, $texto_comentario, $_SESSION['user_name'],1)) 
				session::setFlashMessage('actions_message', strTranslate("Video_comment_insert_ok"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Video_comment_insert_ko"), "alert alert-warning");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function validateCommentAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'elem_ko'){
			$videos = new videos();
			$videos->cambiarEstadoComentario($_REQUEST['idc'],2);

			session::setFlashMessage('actions_message', "Comentario cancelado", "alert alert-warning");
			redirectURL("admin-videos-comentarios?id=".$_REQUEST['id']);
		}
	}

	public static function voteCommentAction($destination = "videos"){
		if (isset($_REQUEST['idvc']) and $_REQUEST['idvc'] != "") { 
			$videos = new videos();
			$response = $videos->InsertVotacionVideo($_REQUEST['idvc'],$_SESSION['user_name']);
			if ($response == 1)
				$message = strTranslate("Video_comment_vote_ok");
			elseif ($response == 2)
				$message = strTranslate("Video_comment_vote_repeat");
			elseif ($response == 3)
				$message = strTranslate("Video_comment_vote_own");

			if (isset($_REQUEST['f']) and $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
			if (isset($_REQUEST['pag2']) and $_REQUEST['pag2'] != "") $destination .= "&pag2=".$_REQUEST['pag2'];

			session::setFlashMessage('actions_message', $message, "alert alert-warning");
			redirectURL($destination);
		}	
	}	

	/**
	 * Funcion para obtener variables del paginador
	 * @param 	int 		$reg 			Número de registros por página
	 */
	public static function PaginatorPagesVideoComments($reg){
		$find_reg = "";
		$pag = 1;
		$inicio = 0;
		if (isset($_GET["pag2"]) and $_GET["pag2"] != "") {
			$pag = $_GET["pag2"];
			$inicio = ($pag - 1) * $reg;
		}
		return array('find_reg' => $find_reg,
					'pag' => $pag,
					'inicio' =>$inicio );
	}	
}
?>