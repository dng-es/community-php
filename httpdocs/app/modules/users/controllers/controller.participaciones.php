<?php
class usersParticipacionesController{
	public static function getListAction($reg = 0, $filter = ''){
		$users = new users();
		$find_reg = getFindReg();
		$filter .= " ORDER BY participacion_date DESC ";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("users_participaciones", $filter);
		return array('items' => $users->getParticipaciones($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
			'pag' 		=> $paginator_items['pag'],
			'reg' 		=> $reg,
			'find_reg' 	=> $find_reg,
			'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users();
			$elements = $users->getParticipaciones(" ORDER BY participacion_date DESC ");
			download_send_headers("data_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>