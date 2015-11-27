<?php
class recompensasController{
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
				session::setFlashMessage('actions_message', "Recompensa eliminada correctamente", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', "Error al eliminar recompensa", "alert alert-danger");
			redirectURL("admin-user?id=".$_REQUEST['id']."&t=2");
		}
	}

	public static function insertUserRewardAction(){
		if(isset($_POST['recompensa_user']) and $_POST['recompensa_user'] != ""){
			$recompensas = new recompensas;
			if ($recompensas->insertRecompensaUser($_POST['id_recompensa'],sanitizeInput($_POST['recompensa_user']), $_SESSION['user_name'])) 
				session::setFlashMessage('actions_message', "Recompensa creada correctamente", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', "Error al crear recompensa", "alert alert-danger");
			redirectURL($_SERVER['REQUEST_URI']."&t=2");
		}	
	}
}
?>