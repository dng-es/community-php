<?php
class recompensasController{
	public static function getItemAction($id){
		$recompensas = new recompensas();
		$element = array();
		$elements = $recompensas->getRecompensas(" AND id_recompensa=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['recompensa_image'] = "";
			$element['recompensa_name'] = "";
		}
		return $element;
	}

	public static function getListAction($reg = 0, $filter = ""){
		$recompensas = new recompensas();
		$find_reg = "";
		if (isset($_POST['find_reg'])){
			$filter .= " AND recompensa_name LIKE '%".$_POST['find_reg']."%' ";
			$find_reg = $_POST['find_reg'];
		}
		if (isset($_REQUEST['f'])){
			$filter .= " AND recompensa_name LIKE '%".$_REQUEST['f']."%' ";
			$find_reg = $_REQUEST['f'];
		}
		$filter .= " ORDER BY recompensa_name";
		$paginator_items = PaginatorPages($reg);		
		$total_reg = connection::countReg("recompensas", $filter);
		return array('items' => $recompensas->getRecompensas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['id_recompensa']) && $_POST['id_recompensa'] == 0){
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
		if (isset($_POST['id_recompensa']) && $_POST['id_recompensa'] > 0){
			$recompensas = new recompensas();	
			$recompensa_nombre = sanitizeInput($_POST['recompensa_nombre']);
			$recompensa_image = ((isset($_FILES['recompensa_image']['name']) && $_FILES['recompensa_image']['name'] != "") ? uploadFileToFolder($_FILES['recompensa_image'], PATH_REWARDS) : $_POST['nombre_imagen']);

			if ($recompensas->updateRecompensas($_POST['id_recompensa'], $recompensa_nombre, $recompensa_image)){
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function getListUserListAction($reg = 0, $filter = ""){
		$recompensas = new recompensas();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("recompensas_user", $filter);
		return array('items' => $recompensas->getRecompensasUserList($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListUserAction($filter = ""){
		$recompensas = new recompensas();
		$find_reg = "";

		$total_recomensas = $recompensas->getRecompensasUser($filter);
		return array('items' => $total_recomensas,
					'find_reg' 	=> $find_reg,
					'total_reg' => count($total_recomensas));
	}

	public static function deleteUserRewardAction(){
		if(isset($_REQUEST['del_rew']) && $_REQUEST['del_rew'] != ""){
			$recompensas = new recompensas;
			if ($recompensas->deleteRecompensaUser(sanitizeInput($_REQUEST['del_rew']))) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-user?id=".$_REQUEST['id']."&t=2");
		}
	}

	public static function insertUserRewardAction(){
		if(isset($_POST['recompensa_user']) && $_POST['recompensa_user'] != ""){
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