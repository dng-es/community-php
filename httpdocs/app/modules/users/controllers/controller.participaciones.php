<?php
class usersParticipacionesController{
	public static function getListAction($reg = 0){
		$users = new users();
		$filtro = " ORDER BY participacion_date DESC ";
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("users_participaciones",$filtro);
		return array('items' => $users->getParticipaciones($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
			'pag' 		=> $paginator_items['pag'],
			'reg' 		=> $reg,
			'find_reg' 	=> $find_reg,
			'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true) {
			$users = new users();
			$elements = $users->getParticipaciones(" ORDER BY participacion_date DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>