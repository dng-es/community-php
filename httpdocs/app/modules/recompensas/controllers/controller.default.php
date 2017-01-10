<?php
class recompensasController{
	public static function getItemAction($id){
		$recompensas = new recompensas();
		return $recompensas->getRecompensas(" AND id_recompensa=".$id." ");
	}

	public static function getListAction($reg = 0, $filtro = ""){
		$recompensas = new recompensas();
		$find_reg = "";
		$filtro .= " ORDER BY recompensa_name";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("recompensas",$filtro);
		return array('items' => $recompensas->getRecompensas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['id_recompensa']) and $_POST['id_recompensa'] == 0){
			$recompensas = new recompensas();
			$id = 0;
			$recompensa_nombre = sanitizeInput($_POST['recompensa_nombre']);
			$recompensa_image = uploadFileToFolder($_FILES['recompensa_image'], PATH_REWARDS);

			if ($recompensas->insertRecompensas($recompensa_nombre, $recompensa_image)){
				$id = connection::SelectMaxReg("id_recompensa", "recompensas", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-recompensa?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_recompensa']) and $_POST['id_recompensa'] > 0){
			$recompensas = new recompensas();	
			$recompensa_nombre = sanitizeInput($_POST['recompensa_nombre']);
			$recompensa_image = ((isset($_FILES['recompensa_image']['name']) and $_FILES['recompensa_image']['name'] != "") ? uploadFileToFolder($_FILES['recompensa_image'], PATH_REWARDS) : $_POST['nombre_imagen']);

			if ($recompensas->updateRecompensas($_POST['id_recompensa'], $recompensa_nombre, $recompensa_image)){
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function getListUserListAction($reg = 0, $filtro = ""){
		$recompensas = new recompensas();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("recompensas_user",$filtro);
		return array('items' => $recompensas->getRecompensasUserList($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListUserAction($filtro = ""){
		$recompensas = new recompensas();
		$find_reg = "";

		$total_recomensas = $recompensas->getRecompensasUser($filtro);
		return array('items' => $total_recomensas,
					'find_reg' 	=> $find_reg,
					'total_reg' => count($total_recomensas));
	}

	public static function deleteUserRewardAction(){
		if(isset($_REQUEST['del_rew']) and $_REQUEST['del_rew'] != ""){
			$recompensas = new recompensas;
			if ($recompensas->deleteRecompensaUser(sanitizeInput($_REQUEST['del_rew']))) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-user?id=".$_REQUEST['id']."&t=2");
		}
	}

	public static function insertUserRewardAction(){
		if(isset($_POST['recompensa_user']) and $_POST['recompensa_user'] != ""){
			$recompensas = new recompensas;
			if (!sanitizeInput($_POST['id_recompensa']) > 0)
				session::setFlashMessage('actions_message', "Tienes que selecionar una recompensa", "alert alert-warning");
			elseif ($recompensas->insertRecompensaUser($_POST['id_recompensa'], sanitizeInput($_POST['recompensa_user']), $_SESSION['user_name'], sanitizeInput($_POST['recompensa_comment']))) 
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL($_SERVER['REQUEST_URI']."&t=2");
		}
	}
}
?>