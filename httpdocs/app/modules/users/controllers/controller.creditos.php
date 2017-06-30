<?php
class usersCreditosController{
	public static function getListAction($reg = 0){
		$users = new users();
		$filter = " AND credito_puntos<>0 ORDER BY credito_date DESC ";
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("users_creditos", $filter); 
		return array('items' => $users->getCreditos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users(); 
			$filter = " AND credito_puntos<>0 ";
			$elements = $users->getCreditos($filter." ORDER BY credito_date DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function getCreditosAction($username, $filter = ""){
		if ($username != ""){
			$users = new users();
			$elements = $users->getUsersCreditos(" AND credito_username='".$username."' ".$filter);
			return $elements;
		}
	}

	public static function updateCreditosAction($username, $creditos, $id_product){
		if ($username != ""){
			users::updateCredito($username, $creditos);
			users::insertCredito($username, $creditos, "Compras premios", "Producto ID.".$id_product);

			if(getModuleExist("prestashop")){
				//obtener el id_externo del usuario
				$usuario = usersController::getPerfilAction($username);
				if ($usuario['id_externo'] > 0) prestashopCreditsController::insertCredits($usuario['id_externo'], $puntos);
			}
		}
	}

	public static function sumarCreditosAction($username, $creditos, $motivo, $detalle = ""){
		if ($username != "" && $creditos != 0){
			if (users::sumarCreditos($username, $creditos, $motivo, $detalle)){
				if(getModuleExist("prestashop")){
					//obtener el id_externo del usuario
					$usuario = usersController::getPerfilAction($username);
					if ($usuario['id_externo'] > 0) prestashopCreditsController::insertCredits($usuario['id_externo'], $creditos);
				}
				return true;
			}

		}
	}	
}
?>