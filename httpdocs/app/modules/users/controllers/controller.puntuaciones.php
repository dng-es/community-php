<?php
class usersPuntuacionesController{
	public static function getListAction($reg = 0, $filter = ''){
		$users = new users();
		$find_reg = getFindReg();
		$filter .= " AND puntuacion_puntos<>0 ORDER BY puntuacion_date DESC ";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("users_puntuaciones", $filter); 
		return array('items' => $users->getPuntuaciones($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
			'pag' 		=> $paginator_items['pag'],
			'reg' 		=> $reg,
			'find_reg' 	=> $find_reg,
			'total_reg' => $total_reg);
	}

	public static function exportListAction($filter = ''){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users(); 
			$filter .= " AND puntuacion_puntos<>0 ";
			$elements = $users->getPuntuaciones($filter." ORDER BY puntuacion_date DESC ");
			download_send_headers("data_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>