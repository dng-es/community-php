<?php
class fotosController{
	public static function getListAction($reg = 0, $filter = ""){
		$fotos = new fotos();
		$find_reg = ((isset($_REQUEST['f']) and $_REQUEST['f'] != 'null') ? $_REQUEST['f'] : (isset($_POST['find_reg']) ? $_POST['find_reg'] : ""));
		if ($find_reg !="" ) {$filter = " AND titulo LIKE '%".$find_reg."%' ".$filter;}
		if ($_SESSION['user_canal'] != 'admin' and $_SESSION['user_perfil'] != 'formador'){$filter = " AND f.canal='".$_SESSION['user_canal']."' ".$filter;}
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("galeria_fotos f", $filter); 
		return array('items' => $fotos->getFotos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['titulo-foto']) and $_POST['titulo-foto']!=""){
			$fotos = new fotos();	
			$canal = (($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador') ? $_SESSION['user_canal'] : $_POST['canal-foto']);		
			$formacion = (($_SESSION['user_perfil']=='formador') ? 1 : 0);	
			$response = $fotos->insertFile($_FILES['nombre-foto'],PATH_FOTOS,$canal,$_POST['titulo-foto'],0,$formacion);
			if ($response == 0){
				$message = strTranslate("Photo_upload_ko0");
			}
			elseif ($response == 1){
				$message = strTranslate("Photo_upload_ok");
			}
			elseif ($response == 2){
				$message = strTranslate("Photo_upload_ko1");
			}
			elseif ($response == 3){
				$message = strTranslate("Photo_upload_ko2");
			}

			session::setFlashMessage( 'actions_message', $message, "alert alert-warning");
			redirectURL($_SERVER['REQUEST_URI']);
		}			
	}

	public static function voteAction($destination = "fotos"){
		if (isset($_REQUEST['idvf']) and $_REQUEST['idvf']!="") { 
			$fotos = new fotos();
			$response = $fotos->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);
			if ($response == 1){
				$message = strTranslate("Photo_vote_ok");
			}
			elseif ($response == 2){
				$message = strTranslate("Photo_vote_repeat");
			}
			elseif ($response == 3){
				$message = strTranslate("Photo_vote_own");
			}

			if (isset($_REQUEST['f']) and $_REQUEST['f']!="") {$destination .= "&f=".$_REQUEST['f'];} 
			if (isset($_REQUEST['pag']) and $_REQUEST['pag']!="") {$destination .= "&pag=".$_REQUEST['pag'];} 

			session::setFlashMessage( 'actions_message', $message, "alert alert-warning");
			redirectURL("?page=".$destination);
		}		
	}		
}
?>